<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Api\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 */
class User implements UserInterface, \Serializable, EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    private $trainerAccepted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostSharing", mappedBy="user")
     */
    private $postSharings;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTrainer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPrivateFollowing;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPrivateFollowers;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastActiveAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserFollowing", mappedBy="follower")
     */
    private $userFollowings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserFollowing", mappedBy="following")
     */
    private $userFollowers;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->postSharings = new ArrayCollection();
        $this->isPrivateFollowers = false;
        $this->isPrivateFollowing = false;
        $this->lastActiveAt = new \DateTime();
        $this->userFollowings = new ArrayCollection();
        $this->userFollowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getTrainerAccepted()
    {
        return $this->trainerAccepted;
    }

    public function setTrainerAccepted($trainerAccepted)
    {
        $this->trainerAccepted = $trainerAccepted;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRole(string $role)
    {
        $this->roles[] = $role;
    }

    public function eraseCredentials()
    {
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->password,
            ] = unserialize($serialized);
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function isPostAuthor(string $username)
    {
        if ($username == $this->getUsername()) {
            return true;
        }

        return false;
    }

    /**
     * @return Collection|PostSharing[]
     */
    public function getPostSharings(): Collection
    {
        return $this->postSharings;
    }

    public function addPostSharing(PostSharing $postSharing): self
    {
        if (!$this->postSharings->contains($postSharing)) {
            $this->postSharings[] = $postSharing;
            $postSharing->setUser($this);
        }

        return $this;
    }

    public function removePostSharing(PostSharing $postSharing): self
    {
        if ($this->postSharings->contains($postSharing)) {
            $this->postSharings->removeElement($postSharing);
            // set the owning side to null (unless already changed)
            if ($postSharing->getUser() === $this) {
                $postSharing->setUser(null);
            }
        }

        return $this;
    }

    public function getIsTrainer(): ?bool
    {
        return $this->isTrainer;
    }

    public function setIsTrainer(bool $isTrainer): self
    {
        $this->isTrainer = $isTrainer;

        return $this;
    }

    public function getIsPrivateFollowing(): ?bool
    {
        return $this->isPrivateFollowing;
    }

    public function setIsPrivateFollowing(bool $isPrivateFollowing): self
    {
        $this->isPrivateFollowing = $isPrivateFollowing;

        return $this;
    }

    public function getIsPrivateFollowers(): ?bool
    {
        return $this->isPrivateFollowers;
    }

    public function setIsPrivateFollowers(bool $isPrivateFollowers): self
    {
        $this->isPrivateFollowers = $isPrivateFollowers;

        return $this;
    }

    public function getLastActiveAt(): ?\DateTimeInterface
    {
        return $this->lastActiveAt;
    }

    public function setLastActiveAt(\DateTimeInterface $lastActiveAt): self
    {
        $this->lastActiveAt = $lastActiveAt;

        return $this;
    }
}
