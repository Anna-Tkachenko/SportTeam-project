<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

interface LoginPageInterface
{
    public function isValidUser(string $username, string $password, UserPasswordEncoderInterface $passwordEncoder);
}
