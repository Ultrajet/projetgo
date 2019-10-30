<?php

namespace App\DataFixtures;

use App\Entity\Jeu;
use App\Entity\User;
use App\Entity\UserJeu;
use App\Service\GenerateurCoordonnees;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $generateurCoordonnees;

    public function __construct(UserPasswordEncoderInterface $encoder, GenerateurCoordonnees $generateurCoordonnees)
    {
        $this->encoder = $encoder;
        $this->generateurCoordonnees = $generateurCoordonnees;
    }

    public function load(ObjectManager $manager)
    {
        // créer les cinq jeux
        $ingress = new Jeu();
        $ingress->setNom('Ingress Prime');
        $manager->persist($ingress);

        $pgo = new Jeu();
        $pgo->setNom('Pokémon Go');
        $manager->persist($pgo);

        $wizards = new Jeu();
        $wizards->setNom('Harry Potter : Wizards Unite');
        $manager->persist($wizards);

        $twd = new Jeu();
        $twd->setNom('The Walking Dead : Our World');
        $manager->persist($twd);

        // $minecraft = new Jeu();
        // $minecraft->setNom('Minecraft Earth');
        // $manager->persist($minecraft);

        $jeux = [$ingress, $pgo, $wizards, $twd];

        $villes = ['Marseille', 'Paris', 'Toulon', 'Lyon', 'Toulouse', 'Nice', 'Montpellier', 'Rennes', 'Lille', 'Nantes'];

        // créer 10 utilisateurs
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername("Jean-Michemuche$i");
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword(
                $this->encoder->encodePassword($user, "motdepasse")
            );
            $user->setEmail("mail$i@mail.fr");

            // générer des localisations réalistes
            // if ($i < 4) {
            //     $ville = "Marseille";
            // } elseif ($i < 8) {
            //     $ville = "Lyon";
            // } else {
            //     $ville = "Paris";
            // }

            // créer entre un et trois UserJeu pour le User en cours
            for ($j = 0; $j < rand(1, 4); $j++) {
                $userJeu = new UserJeu;
                $userJeu->setUser($user);
                // $userJeu->setJeu($jeux[array_rand($jeux)]); ---> risque de générer plusieurs fois le même UserJeu
                $userJeu->setJeu($jeux[$j]);

                $manager->persist($userJeu);
            }

            $userVille = $villes[array_rand($villes)];
            $user->setVille($userVille);

            $coordonnees = $this->generateurCoordonnees->generer($userVille);
            if (is_array($coordonnees)) {
                $user->setCoordonnees($coordonnees);
            }
            else {
                $user->setCoordonnees([51.0347708,2.3772525]);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
