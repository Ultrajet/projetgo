<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeolocController extends AbstractController
{
    /**
     * @Route("/geoloc", name="geoloc")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $users = $repository->findall();

        return $this->render('geoloc/index.html.twig', [
            'users' => $users
        ]);
    }
}
