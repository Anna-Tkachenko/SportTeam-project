<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contract for user service.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface UserPageInterface
{
    public function getCurrentUser();

    public function getUser($currentUser, string $slug);

    public function getUserEntity(string $slug): User;

    public function getAllUsers();

    public function create(Request $request);

    public function findOne(int $id);

    public function update(int $id, array $data);

    public function deleteUser(int $id): void;
}
