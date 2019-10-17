<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $txt_profil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserJeu", mappedBy="user", orphanRemoval=true)
     */
    private $userJeux;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $coordonnees;

    public function __construct()
    {
        $this->userJeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTxtProfil(): ?string
    {
        return $this->txt_profil;
    }

    public function setTxtProfil(?string $txt_profil): self
    {
        $this->txt_profil = $txt_profil;

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
            $userJeux->setUser($this);
        }

        return $this;
    }

    public function removeUserJeux(UserJeu $userJeux): self
    {
        if ($this->userJeux->contains($userJeux)) {
            $this->userJeux->removeElement($userJeux);
            // set the owning side to null (unless already changed)
            if ($userJeux->getUser() === $this) {
                $userJeux->setUser(null);
            }
        }

        return $this;
    }

    public function getCoordonnees(): ?string
    {
        return $this->coordonnees;
    }

    public function setCoordonnees(?string $coordonnees): self
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }
}
