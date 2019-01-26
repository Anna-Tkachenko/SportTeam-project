<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

class UserDto
{
    private $firstName;
    private $lastName;
    private $image;
    private $isPrivateFollowers;
    private $isPrivateFollowing;

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
