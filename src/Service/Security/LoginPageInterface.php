<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/4/19
 * Time: 12:57 PM
 */

namespace App\Service\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

interface LoginPageInterface
{
    public function isValidUser(string $username, string $password, UserPasswordEncoderInterface $passwordEncoder);
}