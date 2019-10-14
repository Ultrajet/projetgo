<?php

namespace App\DataFixtures;

use App\Entity\Jeu;
use App\Entity\User;
use App\Entity\UserJeu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
        $wizards->setNom('Harry Potter: Wizards Unite');
        $manager->persist($wizards);

        $twd = new Jeu();
        $twd->setNom('The Walking Dead: Our World');
        $manager->persist($twd);

        $minecraft = new Jeu();
        $minecraft->setNom('Minecraft Earth');
        $manager->persist($minecraft);

        $jeux = [$ingress, $pgo, $wizards, $twd, $minecraft];

        // créer 10 utilisateurs
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername("Jean-Michemuche$i");
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword(
                $this->encoder->encodePassword($user, "motdepasse")
            );
            $user->setEmail("mail$i@mail.fr");

            // générer des localisations réalistes
            if ($i < 4) {
                $user->setCodePostal("13001");
                $user->setVille("Marseille");
            } elseif ($i < 8) {
                $user->setCodePostal("69001");
                $user->setVille("Lyon");
            } else {
                $user->setCodePostal("75001");
                $user->setVille("Paris");
            }

            // créer entre un et trois UserJeu pour le User en cours
            for ($j = 0; $j < rand(1, 3); $j++) {
                $userJeu = new UserJeu;
                $userJeu->setUser($user);
                // $userJeu->setJeu($jeux[array_rand($jeux)]); ---> risque de générer plusieurs fois le même UserJeu
                $userJeu->setJeu($jeux[$j]);

                $manager->persist($userJeu);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
