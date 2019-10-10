<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // créer 10 utilisateurs
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername("Jean-Michemuche" . $i);
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword();
            $manager->persist($user);
        }

        $manager->flush();

        $manager->flush();
    }
}
