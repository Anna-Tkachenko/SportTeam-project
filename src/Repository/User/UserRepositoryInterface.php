<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

interface UserRepositoryInterface extends UserLoaderInterface
{
    public function loadUserByUsername($username);

    public function save(User $user): void;

    public function delete(int $id): void;

    public function loadUnActiveUser(\DateTimeInterface $datetime);

    public function loadById(array $id);

    public function loadAllUsers();
}
