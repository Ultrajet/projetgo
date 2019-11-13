<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
//use App\Notification\ContactNotification;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    // Cette méthode récupére le mail et son contenu
    // Puis le transforme en objet
    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    
    // Ici les données brutes (l'objet) sont traitées dans le template des emails
    // Afin de pouvoir être lisibles lors de son arrivée sur la boîte mail
    public function notify(Contact $contact){
        $message = (new \Swift_Message('Contact')) //Génére un message
            ->setFrom($contact->getEmail()) // L'email vient du site
            ->setTo('sylviemorin82@gmail.com') // A qui est destiné l'email
            ->setReplyTo($contact->getEmail()) // Réponse à l'email -> capture de l'email de l'utilisateur
            ->setBody($this->renderer->render('emails/contacts.html.twig', [
                'contact' => $contact
            ]), 'text/html');

            return $this->mailer->send($message);
    }
}