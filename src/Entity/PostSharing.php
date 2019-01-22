<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostSharingRepository")
 */
class PostSharing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sharingTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postSharings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="postSharings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    public function __construct()
    {
        $this->sharingTime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSharingTime(): ?\DateTimeInterface
    {
        return $this->sharingTime;
    }

    public function setSharingTime(\DateTimeInterface $sharingTime): self
    {
        $this->sharingTime = $sharingTime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
