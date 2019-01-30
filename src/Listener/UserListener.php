<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Listener;

use App\Repository\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Updates user activity on each user action.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class UserListener extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetResponseEvent $event)
    {
        $user = $this->getUser();

        if (!empty($user)) {
            $user->setLastActiveAt(new \DateTime());
            $this->userRepository->save($user);
        }
    }
}
