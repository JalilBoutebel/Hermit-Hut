<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\JeuRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $repo): Response
    {
        $categories = $repo->findBy([ "active" => true ]);
        return $this->render('accueil/accueil.html.twig', [
            "categories" => $categories,
        ]);
    }

    #[Route('/jeux/{categorie}', name: 'app_jeux')]
    public function jeux(Categorie $categorie): Response
    {
        return $this->render('accueil/jeux.html.twig', [
            "categorie" => $categorie,
        ]);
    }

    



}
