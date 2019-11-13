<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {

    /**
    * Typage de la propriété 
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=5, max=100)
    */
    private $username;

    /**
    * Getter for Username
    * @return [type]
    */
    public function getUsername()
    {
        return $this->username;
    }

    /**
    * Setter for Username
    * @var [type] username
    * @return self
    */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Email
    */
    private $email;

    /**
    * Getter for Email
    *
    * @return [type]
    */
    public function getEmail()
    {
       return $this->email;
    }

    /**
    * Setter for Email
    * @var [type] email
    * @return self
    */
    public function setEmail($email)
    {
       $this->email = $email;
       return $this;
    }

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=5, max=255)
    */
    private $objet;

    /**
    * Getter for Objet
    * @return [type]
    */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
    * Setter for Objet
    * @var [type] objet
    * @return self
    */
    public function setObjet($objet)
    {
        $this->objet = $objet;
        return $this;
    }


    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=15)
    */
    private $message;

    /**
    * Getter for Message
    * @return [type]
    */
    public function getMessage()
    {
        return $this->message;
    }

    /**
    * Setter for Message
    * @var [type] message
    * @return self
    */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

}