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
        $c1->setLibelle('Rétro');
        $c1->setImage('images/Retro.jpg');
        $c1->setActive(true);
        $manager->persist($c1);

        $c2 = new Categorie();
        $c2->setLibelle('Xbox');
        $c2->setImage('images/Xbox.jpg');
        $c2->setActive(true);
        $manager->persist($c2);

        $c3 = new Categorie();
        $c3->setLibelle('PlayStation');
        $c3->setImage('images/PlayStation.png');
        $c3->setActive(true);
        $manager->persist($c3);

        $c4 = new Categorie();
        $c4->setLibelle('Nintendo');
        $c4->setImage('images/Nintendo.jpg');
        $c4->setActive(true);
        $manager->persist($c4);

        // --- Jeux ---
        $jeux = [
            ['Tomb Raider 1', 'L’archéologue-aventurière britannique Lara Croft est engagée par la femme d’affaires Jacqueline Natla pour retrouver un artefact ancien appelé le Scion. Elle voyage à travers le Pérou (Vilcabamba/Qualopec), la Grèce (monastère de Saint-Francis/Tihocan) puis même dans l’Atlantide, pour récupérer les fragments du Scion. Elle découvre que Natla entend utiliser ce pouvoir pour réveiller des créatures et étendre son règne, et décide de détruire l’artefact pour empêcher sa domination.', 12.89, 'images/Tomb_Raider_1.jpg', $c1],
            ['Crash Bandicoot 1', 'Le marsupial génétiquement modifié Crash Bandicoot, créé par le savant fou Dr Neo Cortex, s’échappe de son plan de devenir commandant de l’armée d’animaux mutants. Crash doit empêcher Cortex d’achever son plan de domination mondiale et sauver sa petite amie (la bandicoot Tawna) tout en déjouant les manigances de Cortex et de son assistant Dr N. Brio. ', 14.99, 'images/CrashBandicoot.jpg', $c1],
            ['Rayman 1', 'Le héros sans membres, Rayman, doit récupérer le « Grand Protoon » (Great Protoon) qui maintenait l’équilibre entre la nature et les habitants de sa vallée. Il affronte le maléfique Mr Dark, libère des « Electoons » capturés et traverse divers mondes en utilisant ses capacités uniques pour restaurer l’ordre.', 14.99, 'images/Rayman1.jpg', $c1],
            ['Battlefield 1942', 'Ce jeu de tir à la première personne se déroule pendant la Seconde Guerre mondiale et couvre les théâtres du Pacifique, de l’Afrique du Nord, de l’Europe et de la Russie. Les joueurs choisissent une des classes d’infanterie (éclaireur, assaut, antichar, médecin, ingénieur) et participent à des batailles entre Alliés et Axe, utilisant des soldats, véhicules terrestres, navals et aériens pour obtenir des points de contrôle.', 11.50, 'images/Battlefield-1942.jpg', $c1],
            ['DK-country', 'Le gorille Donkey Kong et son neveu Diddy Kong partent à l’aventure pour récupérer leur trésor de bananes volé par le crocodile King K. Rool et son armée des Kremlings sur l’Île Kongo Kong. Ils traversent de nombreux niveaux de plates-formes pour vaincre les ennemis et reprendre les bananes.', 25.95, 'images/DK-country.jpg', $c1],
            ['Nights', 'Chaque nuit, les rêves humains se déroulent dans le monde de Nightopia. Les adolescents Elliot Edwards et Claris Sinclair sont entraînés dans ce monde onirique où l’entité exilée NiGHTS s’oppose au tyran Wizeman the Wicked qui dérobe l’énergie des rêves (« Ideya ») pour envahir Nightopia puis le monde réel. Les deux adolescents aidés de NiGHTS doivent empêcher ce plan.', 45.00, 'images/Nights.jpg', $c1],
            ['Wild Arms 1', 'Le jeu prend place sur la planète mourante Filgaia, ravagée par la désertification. Le joueur contrôle trois aventuriers appelés « Dream Chasers » (chasseurs de rêves) qui parcourent ce monde mêlant ambiance western et fantasy : ils combattent des créatures appelées Anomalies à l’aide d’armes traditionnelles appelées ARM.', 50.00, 'images/Wild-Arms.jpg', $c1],
            ['Otogi 1', 'Le guerrier Raikoh Minamoto, originaire d’un clan d’exécuteurs, refuse d’exécuter son propre père, vole l’épée ancestrale de son clan, ce qui brise le sceau séparant le monde des démons du monde humain. Une horde de démons envahit Kyoto, et Raikoh est tué. Une princesse l’aide à revenir à mi-vie et lui confie pour tâche de restaurer le Grand Sceau. Il doit ainsi collecter des « Essences » élémentaires, affronter les démons et le responsable de la catastrophe afin de purifier le Japon.', 50.00, 'images/Otogi-1.jpg', $c1],
            ['Forza Horizon 2', '', 0, 'images/Forza-Horizon-2.jpg', $c2],
            ['Killer Instinct 2013', 'images/Killer-Instinct-2013.jpg', $c2],
            ['Sunset Overdrive', 'images/sunset.webp', $c2],
            ['Halo 2', 'images/Halo_2.jpg', $c2],
            ['Redfall', 'images/Redfall.jpg', $c2],
            ['Starfield', 'images/Starfield.png', $c2],
            ['Gears Tactics', 'images/Gears-Tactics.jpg', $c2],
            ['Halo Infinite', 'images/HaloInfinite.webp', $c2],
            ['InFamous', 'images/inFamous.jpg', $c3],
            ['Last Guardian', 'images/Last-Guardian.jpg', $c3],
            ['Bloodborne', 'images/Bloodborne.jpg', $c3],
            ['Gravity Rush 2', 'images/Gravity-Rush.jpg', $c3],
            ['Destruction Allstars', 'images/DestructionAllstars.jpg', $c3],
            ['Ghost Of Yotei', 'images/GhostOfYotei.jpg', $c3],
            ['Ratchet & Clank', 'images/RatchetNClank.jpg', $c3],
            ['Astro Bot', 'images/AstroBot.jpg', $c3],
            ['Animal Crossing', 'images/AnimalCrossing.jpg', $c4],
            ['ARMS', 'images/ARMS.jpg', $c4],
            ['Bayonetta 3', 'images/Bayonetta3.jpg', $c4],
            ['Astral Chain', 'images/AstralChain.jpg', $c4],
            ['DK Bananza', 'images/DKBanan.jpg', $c4],
            ['Mario Kart World', 'images/MarioKartW.jpg', $c4],
            ['Hyrule Warriors', 'images/HyruleWarriors.jpg', $c4],
            ['Kirby Air Riders', '', 0, 'images/Kirby.jpg', $c4],
        ];

        foreach ($jeux as [$nom, $description, $prix, $image, $categorie]) {
            $jeu = new Jeu();
            $jeu->setLibelle($nom);
            $jeu->setDescription($description);
            $jeu->setPrix($prix);
            $jeu->setImage($image);
            $jeu->setCategorie($categorie);
            $jeu->setActive(true);
            $manager->persist($jeu);
        }

        // --- Création d’un utilisateur admin ---
        $user = new User();
        $user->setEmail('user@hotmail.com');
        $user->setNom('Admin');      // ← Ajoute cette ligne
        $user->setPrenom('System'); 
        $password_hash = $this->hasher->hashPassword($user, '5678');
        $user->setPassword($password_hash);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($user);

        // --- Validation finale ---
        $manager->flush();

        

        $user1 = new User();
        $user1->setEmail('nothing@gmail.com');
        $user->setNom('');      // ← Ajoute cette ligne
        $user->setPrenom('System'); 
        $password_hash = $this->hasher->hashPassword($user1, '8765');
        $user1->setPassword($password_hash);
        $user1->setRoles([]);
        $manager->persist($user1);

        // --- Validation finale ---
        $manager->flush();
    }
}


