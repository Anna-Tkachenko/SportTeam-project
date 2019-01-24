<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Following;

use App\Repository\User\UserRepositoryInterface;

class FollowService implements FollowServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function follow($currentUser, $user)
    {
        $currentUser->addFollowing($user);
        $user->addFollower($currentUser);
        $this->saveUser($user);
        $this->saveUser($currentUser);
    }

    public function unFollow($currentUser, $user): void
    {
        $currentUser->removeFollowing($user);
        $user->removeFollower($currentUser);
        $this->saveUser($user);
        $this->saveUser($currentUser);
    }

    public function getFollowing(string $slug)
    {
        $user = $this->getUserEntity($slug);

        return $user->getFollowing();
    }

    public function getFollowers(string $slug)
    {
        $user = $this->getUserEntity($slug);

        return $user->getFollowers();
    }

    public function saveUser($user): void
    {
        $this->userRepository->save($user);
    }

    public function getUserEntity(string $slug)
    {
        return $this->userRepository->findOneBy(['username' => $slug]);
    }
}
