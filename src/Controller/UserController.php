<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function profil($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/profil/modifier", name="modifier_profil")
     */
    public function modifierProfil()
    {
        return $this->render('user/modifier_profil.html.twig');
    }
}
