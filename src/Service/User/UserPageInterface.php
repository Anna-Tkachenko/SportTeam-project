<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

/**
 * Contract for user service.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface UserPageInterface
{
    public function getCurrentUser();

    public function getUser($currentUser, string $slug);

    public function getUserEntity(string $slug);

    public function getPosts(string $slug);

    public function verifyPostAdding(string $username, $datetime);

    public function getAllUsers();

    public function create(array $data);

    public function findOne(int $id);

    public function update(int $id, array $data);

    public function deleteUser(int $id);
}
