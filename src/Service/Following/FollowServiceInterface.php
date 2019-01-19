<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 23:13
 */

namespace App\Service\Following;


interface FollowServiceInterface
{
    public function getFollowing(string $slug);

    public function getFollowers(string $slug);

    public function getUserEntity(string $slug);

    public function saveUser($user);

    public function getFollowStatus(string $currentUsername, string $selectUsername);

    public function follow($currentUser, $user);

    public function unFollow($currentUser, $user);
}