<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messagesReceived")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userGet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUserPost(): ?User
    {
        return $this->userPost;
    }

    public function setUserPost(?User $userPost): self
    {
        $this->userPost = $userPost;

        return $this;
    }

    public function getUserGet(): ?User
    {
        return $this->userGet;
    }

    public function setUserGet(?User $userGet): self
    {
        $this->userGet = $userGet;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
