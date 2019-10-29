<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/profil/modifier", name="modifierProfil")
     */
    public function modifierProfil(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            dump($form->getViewData());
            exit;
        }

        return $this->render('user/modifier_profil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function profil($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $thisUserId = $this->getUser()->getId();
        $owner = $thisUserId == $id ? true : false;

        $user = $repository->find($id);

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'owner' => $owner
        ]);
    }
}
