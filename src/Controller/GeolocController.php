<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GeolocController extends AbstractController
{
    /**
     * @Route("/geoloc", name="geoloc")
     */
    public function index()
    {
        return $this->render('geoloc/index.html.twig', [
            'controller_name' => 'GeolocController',
        ]);
    }
}
