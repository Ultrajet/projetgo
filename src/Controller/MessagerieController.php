<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagerieController extends AbstractController
{
    /**
     * @Route("/message/{id}", name="messagerie")
     */
    public function message($id)
    {
        return $this->render('messagerie/index.html.twig', [
            'id' => $id
        ]);
    }
}
