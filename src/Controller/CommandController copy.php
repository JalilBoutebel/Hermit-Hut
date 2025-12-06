<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Service\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

class CommandController extends AbstractController
{
    // Liste des commandes de l'utilisateur
    #[Route('/command', name: 'app_command')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        // Les commandes sont accessibles via app.user.commandes dans Twig
        return $this->render('command/index.html.twig');
    }

    // Page de finalisation de commande (checkout)
    #[Route('/command/checkout', name: 'app_command_checkout')]
    #[IsGranted('ROLE_USER')]
    public function checkout(Panier $panier): Response
    {
        $panierData = $panier->get();

        if (empty($panierData)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier');
        }

        return $this->render('command/checkout.html.twig', [
            'panier' => $panierData,
        ]);
    }

    // Traitement de la commande
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

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setDateCommande(new \DateTime());
        $commande->setStatut('en_attente');

        // Récupérer les données du formulaire
        $commande->setAdresseLivraison(
            $request->request->get('adresse') . ', ' .
                $request->request->get('code_postal') . ' ' .
                $request->request->get('ville') . ', ' .
                $request->request->get('pays')
        );
        $commande->setTelephone($request->request->get('telephone'));
        $commande->setModePaiement($request->request->get('paiement'));

        // Calculer le total et créer les lignes de commande
        $total = 0;
        $lineItems = [];
        foreach ($panierData as $item) {
            $ligneCommande = new LigneCommande();
            $ligneCommande->setCommande($commande);
            $ligneCommande->setJeu($item['jeu']);
            $ligneCommande->setQuantite($item['quantite']);
            $ligneCommande->setPrix($item['jeu']->getPrix());

            $total += $item['jeu']->getPrix() * $item['quantite'];

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['jeu']->getLibelle
                    ],
                    'unit_ammount' => $item['jeu']->getPrix() * 100,
                ],
                'quantity' => $item['quantite'],
            ];

            $em->persist($ligneCommande);
        }

        if ($request->request->get('paiement') === 'carte_bancaire') {
            Stripe::setApiKey($this->getParameter('STRIPE_SECRET_KEY'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $this->generateUrl(
                    'app_command_success',
                    ['id' => $commande->getId()],
                    \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'cancel_url' => $this->generateUrl(
                    'app_command_cancel',
                    ['id' => $commande->getId()],
                    \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'metadata' => [
                    'commande_id' => $commande->getId(),
                ],
            ]);
            return $this->redirect($session->url);
        }

        $commande->setTotal($total);
        $em->persist($commande);
        $em->flush();

        // Vider le panier
        $request->getSession()->remove('panier');

        $this->addFlash('success', 'Votre commande a été enregistrée avec succès !');

        return $this->redirectToRoute('app_command_details', ['id' => $commande->getId()]);
    }

    // Détails d'une commande
    #[Route('/command/{id}', name: 'app_command_details')]
    #[IsGranted('ROLE_USER')]
    public function details(int $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $commande = $em->getRepository(Commande::class)->find($id);

        if (!$commande || $commande->getUser() !== $user) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        return $this->render('command/details.html.twig', [
            'commande' => $commande,
        ]);
    }
    #[Route('/command/success/{id}', name: 'app_command_success')]
    #[IsGranted('ROLE_USER')]
    public function success(int $id, EntityManagerInterface $em): Response
    {
        $commande = $em->getRepository(Commande::class)->find($id);
        if (!$commande) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        // Mettre à jour le statut de la commande
        $commande->setStatut('payee');
        $em->flush();

        return $this->render('command/success.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/command/cancel/{id}', name: 'app_command_cancel')]
    #[IsGranted('ROLE_USER')]
    public function cancel(int $id, EntityManagerInterface $em): Response
    {
        $commande = $em->getRepository(Commande::class)->find($id);
        if (!$commande) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        $this->addFlash('warning', 'Le paiement a été annulé.');
        return $this->redirectToRoute('app_command_details', ['id' => $commande->getId()]);
    }
}
