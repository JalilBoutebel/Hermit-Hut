<?php

namespace App\Controller;

use App\Entity\Jeu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details', methods: ['GET'])]
    public function index(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $jeu = $em->getRepository(Jeu::class)->find($id);

        if (!$jeu) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }

        // Si c’est une requête AJAX → renvoyer juste le fragment
        if ($request->isXmlHttpRequest()) {
            return $this->render('details/_details_fragment.html.twig', [
                'jeu' => $jeu,
            ]);
        }

        // Sinon page entière (utile si on teste directement /details/1)
        return $this->render('accueil/details.html.twig', [
            'jeu' => $jeu,
        ]);
    }
}
