<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Jeu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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

        $j1 = new Jeu();
        $j1->setLibelle('Jeu 1');
        $j1->setCategorie($c1);
        $j1->setImage('images/Tomb_Raider_1.jpg');
        $j1->setActive(true);
        $manager->persist($j1);

        $j2 = new Jeu();
        $j2->setLibelle('Jeu 2');
        $j2->setCategorie($c1);
        $j2->setImage('images/CrashBandicoot.jpg');
        $j2->setActive(true);
        $manager->persist($j2);

        $j3 = new Jeu();
        $j3->setLibelle('Jeu 3');
        $j3->setCategorie($c1);
        $j3->setImage('images/Rayman1.jpg');
        $j3->setActive(true);
        $manager->persist($j3);

        $j4 = new Jeu();
        $j4->setLibelle('Jeu 4');
        $j4->setCategorie($c1);
        $j4->setImage('images/Battlefield-1942.jpg');
        $j4->setActive(true);
        $manager->persist($j4);

        $j5 = new Jeu();
        $j5->setLibelle('Jeu 5');
        $j5->setCategorie($c1);
        $j5->setImage('images/DK-country.jpg');
        $j5->setActive(true);
        $manager->persist($j5);

        $j6 = new Jeu();
        $j6->setLibelle('Jeu 6');
        $j6->setCategorie($c1);
        $j6->setImage('images/Nights.jpg');
        $j6->setActive(true);
        $manager->persist($j6);

        $j7 = new Jeu();
        $j7->setLibelle('Jeu 7');
        $j7->setCategorie($c1);
        $j7->setImage('images/Wild-Arms.jpg');
        $j7->setActive(true);
        $manager->persist($j7);

        $j8 = new Jeu();
        $j8->setLibelle('Jeu 8');
        $j8->setCategorie($c1);
        $j8->setImage('images/Otogi-1.jpg');
        $j8->setActive(true);
        $manager->persist($j8);

        $j9 = new Jeu();
        $j9->setLibelle('Jeu 9');
        $j9->setCategorie($c2);
        $j9->setImage('images/Forza-Horizon-2.jpg');
        $j9->setActive(true);
        $manager->persist($j9);

        $j10 = new Jeu();
        $j10->setLibelle('Jeu 10');
        $j10->setCategorie($c2);
        $j10->setImage('images/Killer-Instinct-2013.jpg');
        $j10->setActive(true);
        $manager->persist($j10);

        $j11 = new Jeu();
        $j11->setLibelle('Jeu 11');
        $j11->setCategorie($c2);
        $j11->setImage('images/sunset.webp');
        $j11->setActive(true);
        $manager->persist($j11);

        $j12 = new Jeu();
        $j12->setLibelle('Jeu 12');
        $j12->setCategorie($c2);
        $j12->setImage('images/Halo_2.jpg');
        $j12->setActive(true);
        $manager->persist($j12);

        $j13 = new Jeu();
        $j13->setLibelle('Jeu 13');
        $j13->setCategorie($c2);
        $j13->setImage('images/Redfall.jpg');
        $j13->setActive(true);
        $manager->persist($j13);

        $j14 = new Jeu();
        $j14->setLibelle('Jeu 14');
        $j14->setCategorie($c2);
        $j14->setImage('images/Starfield.png');
        $j14->setActive(true);
        $manager->persist($j14);

        $j15 = new Jeu();
        $j15->setLibelle('Jeu 15');
        $j15->setCategorie($c2);
        $j15->setImage('images/Gears-Tactics.jpg');
        $j15->setActive(true);
        $manager->persist($j15);

        $j16 = new Jeu();
        $j16->setLibelle('Jeu 16');
        $j16->setCategorie($c2);
        $j16->setImage('images/HaloInfinite.webp');
        $j16->setActive(true);
        $manager->persist($j16);

        $j17 = new Jeu();
        $j17->setLibelle('Jeu 17');
        $j17->setCategorie($c3);
        $j17->setImage('images/inFamous.jpg');
        $j17->setActive(true);
        $manager->persist($j17);

        $j18 = new Jeu();
        $j18->setLibelle('Jeu 18');
        $j18->setCategorie($c3);
        $j18->setImage('images/Last-Guardian.jpg');
        $j18->setActive(true);
        $manager->persist($j18);

        $j19 = new Jeu();
        $j19->setLibelle('Jeu 19');
        $j19->setCategorie($c3);
        $j19->setImage('images/Bloodborne.jpg');
        $j19->setActive(true);
        $manager->persist($j19);

        $j20 = new Jeu();
        $j20->setLibelle('Jeu 20');
        $j20->setCategorie($c3);
        $j20->setImage('images/Gravity-Rush.jpg');
        $j20->setActive(true);
        $manager->persist($j20);

        $j21 = new Jeu();
        $j21->setLibelle('Jeu 21');
        $j21->setCategorie($c3);
        $j21->setImage('images/DestructionAllstrars.jpg');
        $j21->setActive(true);
        $manager->persist($j21);

        $j22 = new Jeu();
        $j22->setLibelle('Jeu 22');
        $j22->setCategorie($c3);
        $j22->setImage('images/GhostOfYotei.jpg');
        $j22->setActive(true);
        $manager->persist($j22);

        $j23 = new Jeu();
        $j23->setLibelle('Jeu 23');
        $j23->setCategorie($c3);
        $j23->setImage('images/RatchetNClank.jpg');
        $j23->setActive(true);
        $manager->persist($j23);
        
        $j24 = new Jeu();
        $j24->setLibelle('Jeu 24');;
        $j24->setCategorie($c3);
        $j24->setImage('images/AstroBot.jpg');
        $j24->setActive(true);
        $manager->persist($j24);

        $j25 = new Jeu();
        $j25->setLibelle('Jeu 25');;
        $j25->setCategorie($c4);
        $j25->setImage('images/AnimalCrossing.jpg');
        $j25->setActive(true);
        $manager->persist($j25);

        $j26 = new Jeu();
        $j26->setLibelle('Jeu 26');
        $j26->setCategorie($c4);
        $j26->setImage('images/ARMS.jpg');
        $j26->setActive(true);
        $manager->persist($j26);

        $j27 = new Jeu();
        $j27->setLibelle('Jeu 27');
        $j27->setCategorie($c4);
        $j27->setImage('images/Bayonetta3.jpg');
        $j27->setActive(true);
        $manager->persist($j27);

        $j28 = new Jeu();
        $j28->setLibelle('Jeu 28');
        $j28->setCategorie($c4);
        $j28->setImage('images/AstralChain.jpg');
        $j28->setActive(true);
        $manager->persist($j28);
        
        $j29 = new Jeu();
        $j29->setLibelle('Jeu 29');
        $j29->setCategorie($c4);
        $j29->setImage('images/DKBanan.jpg');
        $j29->setActive(true);
        $manager->persist($j29);

        $j30 = new Jeu();
        $j30->setLibelle('Jeu 30');;
        $j30->setCategorie($c4);
        $j30->setImage('images/MarioKartW.jpg');
        $j30->setActive(true);
        $manager->persist($j30);

        $j31 = new Jeu();
        $j31->setLibelle('Jeu 31');;
        $j31->setCategorie($c4);
        $j31->setImage('images/HyruleWarriors.jpg');
        $j31->setActive(true);
        $manager->persist($j31);

        $j32 = new Jeu();
        $j32->setLibelle('Jeu 32');;
        $j32->setCategorie($c4);
        $j32->setImage('images/Kyrby.jpg');
        $j32->setActive(true);
        $manager->persist($j32);


        $manager->flush();
    }
}
