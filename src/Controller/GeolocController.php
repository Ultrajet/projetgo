<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeolocController extends AbstractController
{
    /**
     * @Route("/geoloc", name="geoloc")
     */
    public function index()
    {
        return $this->render('geoloc/index.html.twig');
    }

    /**
     * @Route("/api/users", name="apiUsers")
     */
    public function apiUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        foreach ($users as $user) {
            $output[$user->getUsername()] = $user->getCoordonnees();
        }

        return new JsonResponse($output);
    }
}
