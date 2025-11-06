<?php

namespace App\Controller;

use App\Form\InscriptionType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if  ($form->isSubmitted()) {

            $mail = $form->get('email')->getData();

            $token = uniquid();

            $email = (new Email())
                ->from('')
                ->to($destiinataire)
                ->subject('Inscription')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);

            $this->addFlash('notice', 'Consulter vos mails');
            return $this->redirect('/');
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form,
        ]);
    }
}
