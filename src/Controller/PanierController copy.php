<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Service\Panier;
use App\Repository\JeuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'panier' => $panier->get(),
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_add_panier')]
    public function panier_add(int $id, JeuRepository $repo, Panier $panier): Response
    {
        $jeu = $repo->find($id);
        if (!$jeu) {
            throw $this->createNotFoundException("Jeu introuvable !");
        }

        $panier->add($jeu);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/del/{id}', name: 'app_del_panier')]
    public function panier_del(int $id, JeuRepository $repo, Panier $panier): Response
    {
        $jeu = $repo->find($id);
        if (!$jeu) {
            throw $this->createNotFoundException("Jeu introuvable !");
        }

        $panier->del($jeu);
        return $this->redirectToRoute('app_panier');
    }
}
