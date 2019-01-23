<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 21:16
 */

namespace App\Dto;


class UserInfo
{
    private $firstName;
    private $lastName;
    private $image;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
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

}