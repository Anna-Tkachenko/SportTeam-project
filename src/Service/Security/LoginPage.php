<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Security;

use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginPage implements LoginPageInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isValidUser(string $username, string $password, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (null === $user) {
            return false;
        }

        return $passwordEncoder->isPasswordValid($user, $password);
    }
}
