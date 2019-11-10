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

    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    
    public function notify(Contact $contact){
        $message = (new \Swift_Message('Contact')) //Génére un message
            ->setFrom($contact->getEmail()) // L'email viend du site
            ->setTo('sylviemorin82@gmail.com') // L'email va au propriétaire du site
            ->setReplyTo($contact->getEmail()) // Réponse à l'email -> capture de l'email de l'utilisateur
            ->setBody($this->renderer->render('emails/contacts.html.twig', [
                'contact' => $contact
            ]), 'text/html');

            return $this->mailer->send($message);
    }
}