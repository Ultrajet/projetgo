<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Entity\User;
use App\Form\GeolocType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeolocController extends AbstractController
{
    /**
     * @Route("/geoloc", name="geoloc")
     */
    public function index()
    {
        $form = $this->createForm(GeolocType::class);

        return $this->render('geoloc/index.html.twig', [
            'geolocForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/api/users", name="apiUsers")
     */
    public function apiUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        foreach ($users as $user) {
            $output[$user->getUsername()] = [
                'coordonnees' => $user->getCoordonnees(),
                'id' => $user->getId()
            ];
        }

        return new JsonResponse($output);
    }

    /**
     * @Route("/api/users/{jeu}", name="apiUsersGame")
     */
    public function apiUsersGame($jeu)
    {
        $repository = $this->getDoctrine()->getRepository(Jeu::class);        
        $theJeu = $repository->find($jeu);
        $userJeu = $theJeu->getUserJeux();
        
        foreach ($userJeu as $user) {
            $output[$user->getUser()->getUsername()] = [
                'coordonnees' => $user->getUser()->getCoordonnees(),
                'id' => $user->getUser()->getId()
            ];
        }

        return new JsonResponse($output);
    }
}
