<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

use App\Exception\NullAttributeException;
use Symfony\Component\HttpFoundation\Request;

class UserDto
{
    private $firstName;
    private $lastName;
    private $image;
    private $isPrivateFollowers;
    private $isPrivateFollowing;
    private $username;
    private $email;
    private $password;
    private $isActive;
    private $isTrainer;

    public static function fromRequest(Request $request): self
    {
        $data = $request->request->get('data')['attributes'];

        if (isset($data['username']) && isset($data['first_name']) && isset($data['last_name'])
            && isset($data['plain_password']) && isset($data['email'])
            && isset($data['is_active']) && isset($data['is_trainer'])) {
        } else {
            throw new NullAttributeException();
        }

        $user = new self();
        $user->setUsername($data['username']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setPassword($data['plain_password']);
        $user->setEmail($data['email']);
        $user->setIsActive($data['is_active']);
        $user->setIsTrainer($data['is_trainer']);

        return $user;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function isTrainer(): ?bool
    {
        return $this->isTrainer;
    }

    public function setIsTrainer(bool $isTrainer): void
    {
        $this->isTrainer = $isTrainer;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getIsPrivateFollowers(): bool
    {
        return $this->isPrivateFollowers;
    }

    public function setIsPrivateFollowers(bool $isPrivateFollowers): void
    {
        $this->isPrivateFollowers = $isPrivateFollowers;
    }

    public function getIsPrivateFollowing(): bool
    {
        return $this->isPrivateFollowing;
    }

    public function setIsPrivateFollowing(bool $isPrivateFollowing): void
    {
        $this->isPrivateFollowing = $isPrivateFollowing;
    }
}
