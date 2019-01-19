<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Provides changes on logout.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class LogoutListener implements LogoutHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @{inheritDoc}
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();
        $user->setIsActive(false);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token->setAuthenticated(false);
    }
}
