<?php

namespace App\Service;

use App\Entity\Jeu;
use App\Repository\JeuRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Panier {
    private $session;
    private $repo;

    public function __construct(RequestStack $request, JeuRepository $repo)
    {
        $this->session = $request->getSession();
        $this->repo = $repo;
    }

    public function add(Jeu $jeu): void
    {
        $panier = $this->session->get("panier", []);
        $id = $jeu->getId();

        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set("panier", $panier);
    }

    public function del(Jeu $jeu): void
    {
        $panier = $this->session->get("panier", []);
        $id = $jeu->getId();

        if (isset($panier[$id])) {
            $panier[$id]--;
            if ($panier[$id] <= 0) {
                unset($panier[$id]);
            }
        }

        $this->session->set("panier", $panier);
    }

    public function get(): array
    {
        $panier = $this->session->get("panier", []);
        $panier_pour_twig = [];

        foreach ($panier as $id_jeu => $quantite) {
            $jeu = $this->repo->find($id_jeu);
            if ($jeu) {
                $panier_pour_twig[] = [
                    "jeu" => $jeu,
                    "quantite" => $quantite
                ];
            }
        }

        return $panier_pour_twig;
    }
}
