<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 3:40 PM
 */

namespace App\Service\User;


interface UserPageInterface
{
    public function getCurrentUser();

    public function getUser(string $slug);

    public function getUserEntity(string $slug);

    public function getPosts(string $slug);

    public function getPost(string $id);

    public function verifyPostAdding(string $username, $datetime);

    public function getFollowers(string $slug);

    public function getFollowing(string $slug);

    public function getFollowStatus(string $currentUsername, string $selectUsername);

    public function getAllUsers();
}