<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Entity\User;
use App\Form\JeuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**********************************************************************
                                ADMIN USER
    ***********************************************************************/

    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function admin_user()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('admin/user.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/add", name="admin_user_add")
     */

    /**********************************************************************
                                ADMIN JEUX
    ***********************************************************************/    

    /* ---- LISTE DE JEUX ---- */

     /**
     * @Route("/admin/jeu", name="admin_jeu")
     */
    public function admin_jeu()
    {
        $repository = $this->getDoctrine()->getRepository(Jeu::class);
        $jeux = $repository->findAll();
        return $this->render('admin/jeu.html.twig', [
            'jeux' => $jeux,
        ]);
    }

    /* ---- AJOUTER UN JEUX ---- */

    /**
     * @Route("/admin/jeu/add", name="admin_jeu_add")
     */
    public function admin_jeu_add(Request $request){
        $jeux = new Jeu;
        $form = $this->createForm(JeuType::class, $jeux);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($jeux);
            $manager->flush();

            $this->addFlash('success', 'Le jeu n°' . $jeux->getId() . ' a bien été enregistré en BDD');

            return $this->redirectToRoute('admin_jeu');
           
        }
        return $this->render('admin/jeu_formulaire.html.twig', [
            'jeuxform' => $form->createView(),
        ]);
    }
}
