<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController{
    /**
     * @Route("/contact", name="contact")
     */
    public function formulaire(Request $request)
    {
        $form = $this->createForm(ContactType::class, null);
        $form -> handleRequest($request);

            //Traitement des infos du formulaire
            if($form -> isSubmitted() && $form -> isValid()){

                //Permet de récupérer toutes les données du formulaire
                // $data = $form -> getData();

                // if($this -> sendEmail($data, $mailer)){
                //     $this -> addFlash('success', 'Votre email à bien été envoyer, nous vous répondrons au plus vite.');
                //     return $this->redirectToRoute("accueil");
                // }else{
                //     $this -> addFlash('errors', 'Un problème est survenue lors de l\'envoie de votre email, veuillez ré-essayer plus tard');
                // }
            }
        return $this->render('/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}