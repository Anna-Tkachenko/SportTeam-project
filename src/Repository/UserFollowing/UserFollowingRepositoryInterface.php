<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 29.01.19
 * Time: 18:34
 */

namespace App\Repository\UserFollowing;


use App\Entity\UserFollowing;

interface UserFollowingRepositoryInterface
{
    public function findFollowings(int $id);

    public function findFollowers(int $id);

    public function save(UserFollowing $userFollowing): void;

    public function delete(int $followerId, int $followingId): void;
}