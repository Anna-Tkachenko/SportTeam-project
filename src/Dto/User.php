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

    public function __construct(
        string $username,
        string $password,
        string $email,
        bool $isActive,
        string $firstName,
        string $lastName,
        $image
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->isActive = $isActive;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->image = $image;
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
        if (is_null($this->image)) {
            return '/img/default.png';
        }
        return $this->image;
    }
}
