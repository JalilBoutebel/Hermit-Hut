<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Panier;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use App\Entity\LigneCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{
    #[Route('/command/checkout', name: 'app_command_checkout')]
    #[IsGranted('ROLE_USER')]
    public function checkout(Panier $panier): Response
    {
        $panierData = $panier->get();

        if (empty($panierData)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier');
        }

        // Calculer le total
        $total = 0;
        foreach ($panierData as $item) {
            $total += $item['jeu']->getPrix() * $item['quantite'];
        }

        return $this->render('command/checkout.html.twig', [
            'panier' => $panierData,
            'total' => $total,
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }

    #[Route('/command/process', name: 'app_command_process', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function processCommand(Request $request, Panier $panier, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $panierData = $panier->get();

        if (empty($panierData)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier');
        }

        $data = $request->request->all();
        $paymentMethodId = $data['paymentMethodId'] ?? null;

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setDateCommande(new \DateTime());
        $commande->setStatut('en_attente');
        $commande->setAdresseLivraison($data['adresse'] . ', ' . $data['code_postal'] . ' ' . $data['ville'] . ', ' . $data['pays']);
        $commande->setTelephone($data['telephone']);
        $commande->setModePaiement($data['paiement']);

        // Calculer le total et créer les lignes de commande
        $total = 0;
        foreach ($panierData as $item) {
            $ligneCommande = new LigneCommande();
            $ligneCommande->setCommande($commande);
            $ligneCommande->setJeu($item['jeu']);
            $ligneCommande->setQuantite($item['quantite']);
            $ligneCommande->setPrix($item['jeu']->getPrix());
            $total += $item['jeu']->getPrix() * $item['quantite'];
            $em->persist($ligneCommande);
        }

        $commande->setTotal($total);
        $em->persist($commande);
        $em->flush();

        // Si le mode de paiement est "carte_bancaire" et qu'un paymentMethodId est fourni
        if ($data['paiement'] === 'carte_bancaire' && $paymentMethodId) {
            Stripe::setApiKey($this->getParameter('stripe_secret_key'));

            try {
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $total * 100, // Convertir en centimes
                    'currency' => 'eur',
                    'payment_method' => $paymentMethodId,
                    'confirm' => true,
                    'return_url' => $this->generateUrl('app_command_success', ['id' => $commande->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                ]);

                if ($paymentIntent->status === 'succeeded') {
                    $commande->setStatut('payee');
                    $em->flush();
                    $request->getSession()->remove('panier');
                    return $this->redirectToRoute('app_command_success', ['id' => $commande->getId()]);
                } else {
                    $this->addFlash('error', 'Le paiement a échoué.');
                    return $this->redirectToRoute('app_command_cancel', ['id' => $commande->getId()]);
                }
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors du paiement: ' . $e->getMessage());
                return $this->redirectToRoute('app_command_cancel', ['id' => $commande->getId()]);
            }
        }

        // Pour les autres modes de paiement
        $request->getSession()->remove('panier');
        $this->addFlash('success', 'Votre commande a été enregistrée avec succès !');
        return $this->redirectToRoute('app_command_details', ['id' => $commande->getId()]);
    }
}
