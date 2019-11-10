<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;

use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function formulaire(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request); //Gère la requête

        //Traitement des infos du formulaire
        if ($form->isSubmitted() && $form->isValid()) // Si le formualaire est soumis est valide
        {
            // Notifie ce contact et tu t'occupes de la partie traitement
            // Permet de faciliter les tests
            $notification->notify($contact); 

            //Permet de récupérer toutes les données du formulaire
            $data = $form -> getData();

            if($this -> sendEmail($data, $mailer)){
                $this -> addFlash('success', 'Votre email à bien été envoyer, nous vous répondrons au plus vite.'); // Message de validation de l'envoi du mail
                return $this->redirectToRoute("accueil"); //Chemin de redirection suite à un traitement correcte du mail
            }else{
                $this -> addFlash('errors', 'Un problème est survenue lors de l\'envoie de votre email, veuillez ré-essayer plus tard');
            }
        }
        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
    * Permet d'envoyer des emails
    */
    public function sendEmail($data, \Swift_Mailer $mailer){
        $mail = new \Swift_Message();
        // On instancie un objet swiftmailer en précisant l'objet (sujet) du mail.
    
        $mail
            -> setSubject($data['objet'])
            -> setFrom($data['email'])
            -> setTo('sylviemorin82@gmail.com')
            -> setBody($this -> renderView('emails/contacts.html.twig', [
                'data' => $data
            ]), 'text/html');
    
        if($mailer -> send($mail)){
            return true;
        }else{
            return false;
        }
    }
}
