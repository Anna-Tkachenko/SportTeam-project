<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Security;

use App\Exception\FailedCredentialsException;
use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityService implements SecurityServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyUsername(string $username)
    {
        $user = $this->userRepository->loadUserByUsername($username);
        if (null != $user) {
            throw new FailedCredentialsException('This username is already used.');
        }
    }

    public function verifyEmail(string $email)
    {
        $user = $this->userRepository->loadUserByUsername($email);
        if (null != $user) {
            throw new FailedCredentialsException('This email is already used.');
        }
    }
}
