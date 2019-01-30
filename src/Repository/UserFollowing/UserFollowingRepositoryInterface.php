<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\UserFollowing;

use App\Entity\UserFollowing;

/**
 * Contract for user-following repository.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface UserFollowingRepositoryInterface
{
    public function findFollowings(int $id);

    public function findFollowers(int $id);

    public function save(UserFollowing $userFollowing): void;

    public function delete(int $followerId, int $followingId): void;
}
