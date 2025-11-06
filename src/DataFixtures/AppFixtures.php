<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Jeu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --- Catégories ---
        $c1 = new Categorie();
        $c1->setLibelle('Categorie 1');
        $c1->setImage('images/Retro.jpg');
        $c1->setActive(true);
        $manager->persist($c1);

        $c2 = new Categorie();
        $c2->setLibelle('Categorie 2');
        $c2->setImage('images/Xbox.jpg');
        $c2->setActive(true);
        $manager->persist($c2);

        $c3 = new Categorie();
        $c3->setLibelle('Categorie 3');
        $c3->setImage('images/PlayStation.png');
        $c3->setActive(true);
        $manager->persist($c3);

        $c4 = new Categorie();
        $c4->setLibelle('Categorie 4');
        $c4->setImage('images/Nintendo.jpg');
        $c4->setActive(true);
        $manager->persist($c4);

        // --- Jeux ---
        $jeux = [
            ['Jeu 1', 'images/Tomb_Raider_1.jpg', $c1],
            ['Jeu 2', 'images/CrashBandicoot.jpg', $c1],
            ['Jeu 3', 'images/Rayman1.jpg', $c1],
            ['Jeu 4', 'images/Battlefield-1942.jpg', $c1],
            ['Jeu 5', 'images/DK-country.jpg', $c1],
            ['Jeu 6', 'images/Nights.jpg', $c1],
            ['Jeu 7', 'images/Wild-Arms.jpg', $c1],
            ['Jeu 8', 'images/Otogi-1.jpg', $c1],
            ['Jeu 9', 'images/Forza-Horizon-2.jpg', $c2],
            ['Jeu 10', 'images/Killer-Instinct-2013.jpg', $c2],
            ['Jeu 11', 'images/sunset.webp', $c2],
            ['Jeu 12', 'images/Halo_2.jpg', $c2],
            ['Jeu 13', 'images/Redfall.jpg', $c2],
            ['Jeu 14', 'images/Starfield.png', $c2],
            ['Jeu 15', 'images/Gears-Tactics.jpg', $c2],
            ['Jeu 16', 'images/HaloInfinite.webp', $c2],
            ['Jeu 17', 'images/inFamous.jpg', $c3],
            ['Jeu 18', 'images/Last-Guardian.jpg', $c3],
            ['Jeu 19', 'images/Bloodborne.jpg', $c3],
            ['Jeu 20', 'images/Gravity-Rush.jpg', $c3],
            ['Jeu 21', 'images/DestructionAllstars.jpg', $c3],
            ['Jeu 22', 'images/GhostOfYotei.jpg', $c3],
            ['Jeu 23', 'images/RatchetNClank.jpg', $c3],
            ['Jeu 24', 'images/AstroBot.jpg', $c3],
            ['Jeu 25', 'images/AnimalCrossing.jpg', $c4],
            ['Jeu 26', 'images/ARMS.jpg', $c4],
            ['Jeu 27', 'images/Bayonetta3.jpg', $c4],
            ['Jeu 28', 'images/AstralChain.jpg', $c4],
            ['Jeu 29', 'images/DKBanan.jpg', $c4],
            ['Jeu 30', 'images/MarioKartW.jpg', $c4],
            ['Jeu 31', 'images/HyruleWarriors.jpg', $c4],
            ['Jeu 32', 'images/Kirby.jpg', $c4],
        ];

        foreach ($jeux as [$nom, $image, $categorie]) {
            $jeu = new Jeu();
            $jeu->setLibelle($nom);
            $jeu->setCategorie($categorie);
            $jeu->setImage($image);
            $jeu->setActive(true);
            $manager->persist($jeu);
        }

        // --- Création d’un utilisateur admin ---
        $user = new User();
        $user->setEmail('user@hotmail.com');

        $password_hash = $this->hasher->hashPassword($user, '5678');

        $user->setPassword($password_hash);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($user);

        // --- Validation finale ---
        $manager->flush();

        

        $user1 = new User();
        $user1->setEmail('user@gmail.com');

        $password_hash = $this->hasher->hashPassword($user1, '5678');

        $user1->setPassword($password_hash);
        $user1->setRoles([]);
        $manager->persist($user1);

        // --- Validation finale ---
        $manager->flush();
    }
}


