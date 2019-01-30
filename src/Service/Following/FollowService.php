<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Following;

use App\Entity\UserFollowing;
use App\Repository\User\UserRepositoryInterface;
use App\Repository\UserFollowing\UserFollowingRepositoryInterface;

/**
 * Provides user's follow, unfollow functions.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class FollowService implements FollowServiceInterface
{
    private $userRepository;
    private $followingRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserFollowingRepositoryInterface $followingRepository
    ) {
        $this->userRepository = $userRepository;
        $this->followingRepository = $followingRepository;
    }

    public function follow($currentUser, $user)
    {
        $userFollow = new UserFollowing($currentUser, $user);
        $this->followingRepository->save($userFollow);
    }

    public function unFollow($currentUser, $user): void
    {
        $this->followingRepository->delete($currentUser->getId(), $user->getId());
    }

    public function getFollowing(string $slug)
    {
        $userId = $this->getUserEntity($slug)->getId();
        $userFollowingsId = $this->followingRepository->findFollowings($userId);
        $usersId = [];

        foreach ($userFollowingsId as $key => $value) {
            $usersId[] = $value['1'];
        }

        return $this->userRepository->loadById($usersId);
    }

    public function getFollowers(string $slug)
    {
        $userId = $this->getUserEntity($slug)->getId();
        $userFollowersId = $this->followingRepository->findFollowers($userId);
        $usersId = [];

        foreach ($userFollowersId as $key => $value) {
            $usersId[] = $value['1'];
        }

        return $this->userRepository->loadById($usersId);
    }

    public function getUserEntity(string $slug)
    {
        return $this->userRepository->findOneBy(['username' => $slug]);
    }
}
