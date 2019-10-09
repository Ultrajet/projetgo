<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JeuRepository")
 */
class Jeu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserJeu", mappedBy="jeu", orphanRemoval=true)
     */
    private $userJeux;

    public function __construct()
    {
        $this->userJeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|UserJeu[]
     */
    public function getUserJeux(): Collection
    {
        return $this->userJeux;
    }

    public function addUserJeux(UserJeu $userJeux): self
    {
        if (!$this->userJeux->contains($userJeux)) {
            $this->userJeux[] = $userJeux;
            $userJeux->setJeu($this);
        }

        return $this;
    }

    public function removeUserJeux(UserJeu $userJeux): self
    {
        if ($this->userJeux->contains($userJeux)) {
            $this->userJeux->removeElement($userJeux);
            // set the owning side to null (unless already changed)
            if ($userJeux->getJeu() === $this) {
                $userJeux->setJeu(null);
            }
        }

        return $this;
    }
}
