<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ValidationType;
use App\Form\InscriptionType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $manager, UserRepository $repo): Response
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            // Vérifier si l'utilisateur existe déjà
            $existingUser = $repo->findOneBy(['email' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'Un compte avec cet email existe déjà.');
                return $this->redirectToRoute('app_inscription');
            }

            $token = bin2hex(random_bytes(32)); // Token plus sécurisé

            $u = new User();
            $u->setToken($token);
            $u->setEmail($email);
            $u->setNom($form->get('nom')->getData());
            $u->setPrenom($form->get('prenom')->getData());
            // Ne pas enregistrer de mot de passe temporaire
            $u->setPassword(''); // Sera défini lors de la validation

            $manager->persist($u);
            $manager->flush();

            $email = (new TemplatedEmail())
                ->from('nepasrepondre@site.com')
                ->to($email)
                ->subject('Votre inscription')
                ->htmlTemplate('mail/validation.html.twig')
                ->context([
                    "token" => $token
                ]);

            $mailer->send($email);
            $this->addFlash('success', 'Consultez votre boîte aux lettres pour valider votre inscription.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/validation/{token}', name: 'app_validation')]
    public function validation(
        UserPasswordHasherInterface $hasher,
        UserRepository $repo,
        Request $request,
        EntityManagerInterface $manager,
        string $token
    ): Response {
        $user = $repo->findOneBy(["token" => $token]);

        if (!$user) {
            $this->addFlash('error', 'Token invalide ou expiré.');
            return $this->redirectToRoute('app_inscription');
        }

        // Vérifier si le compte est déjà validé
        if ($user->getPassword() !== '') {
            $this->addFlash('info', 'Ce compte a déjà été validé.');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ValidationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $password_hash = $hasher->hashPassword($user, $password);
            $user->setPassword($password_hash);

            $manager->flush();

            $this->addFlash('success', 'Votre compte a été validé avec succès !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/validation.html.twig', [
            "form" => $form,
            "user" => $user
        ]);
    }
}
