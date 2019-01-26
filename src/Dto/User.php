<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

/**
 * User DTO.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class User
{
    private $username;
    private $password;
    private $email;
    private $isActive;
    private $firstName;
    private $lastName;
    private $image;
    private $followStatus;
    private $isTrainer;
    private $isPrivateFollowing;
    private $isPrivateFollowers;

    public const IS_NOT_FOLLOW = 1;
    public const IS_FOLLOW = 2;
    public const IS_THE_SAME = 3;

    public function __construct(
        string $username,
        string $password,
        string $email,
        bool $isActive,
        string $firstName,
        string $lastName,
        $image,
        bool $isTrainer,
        bool $isPrivateFollowing,
        bool $isPrivateFollowers
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->isActive = $isActive;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->image = $image;
        $this->isTrainer = $isTrainer;
        $this->isPrivateFollowing = $isPrivateFollowing;
        $this->isPrivateFollowers = $isPrivateFollowers;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setFollowStatus(int $status)
    {
        $this->followStatus = $status;
    }

    public function getFollowStatus(): ?int
    {
        return $this->followStatus;
    }

    public function isFollowing(): bool
    {
        return self::IS_FOLLOW == $this->followStatus;
    }

    public function isNotFollowing(): bool
    {
        return self::IS_NOT_FOLLOW == $this->followStatus;
    }

    public function isSame(): bool
    {
        return self::IS_THE_SAME == $this->followStatus;
    }

    public function isPostAuthor(string $username): bool
    {
        return $username == $this->getUsername();
    }

    public function isTrainer(): bool
    {
        return $this->isTrainer;
    }

    public function isPrivateFollowing(): bool
    {
        return $this->isPrivateFollowing;
    }

    public function isPrivateFollowers(): bool
    {
        return $this->isPrivateFollowers;
    }
}
