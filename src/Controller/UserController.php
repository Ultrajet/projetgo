<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\UserJeu;
use App\Service\GenerateurCoordonnees;
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
     * @Route("/modifier", name="modifierProfil")
     */
    public function modifierProfil(Request $request, GenerateurCoordonnees $generateurCoordonnees)
    {
        $user = $this->getUser();

        $userJeux = $user->getUserJeux();
        foreach ($userJeux as $userJeu) {
            $output[] = $userJeu->getJeu()->getId();
        }

        $form = $this->createForm(UserType::class, $user, ['userJeu' => $output]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $form->getData();

            $ville = $form->get('ville')->getData();
            $coordonnees = $generateurCoordonnees->generer($ville);
            $user->setCoordonnees($coordonnees);

            // $jeux = $form->get('jeux')->getData();
            // foreach ($jeux as $jeu) {
            //     $userJeu = new UserJeu();
            //     $userJeu
            //         ->setUser($user)
            //         ->setJeu($jeu);
            //     $entityManager->persist($userJeu);
            // }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index');
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
