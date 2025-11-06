<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ✅ Récupération des données du formulaire
            $data = $form->getData();

            // ✅ Création de l'email
            $email = (new Email())
                ->from($data['email'])
                ->to('admin@site.com')
                ->subject($data['subject'])
                ->html('<p>' . nl2br($data['message']) . '</p>');

            // ✅ Envoi du mail
            $mailer->send($email);

            // ✅ Message de confirmation
            $this->addFlash('success', 'Votre message a été envoyé avec succès 🚀');

            // ✅ Redirection pour éviter le renvoi de formulaire
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
