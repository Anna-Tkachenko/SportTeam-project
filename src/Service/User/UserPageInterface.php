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

    public function verifyPostAdding(string $username, $datetime);

    public function getFollowers(string $slug);

    public function getFollowing(string $slug);

    public function getFollowStatus(string $currentUsername, string $selectUsername);

    public function getAllUsers();

    public function create(array $data);

    public function findOne(int $id);

    public function update(int $id, array $data);

    public function deleteUser(int $id);
}