<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 3:43 PM
 */

namespace App\Repository\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

interface UserRepositoryInterface extends UserLoaderInterface
{
    public function loadUserByUsername($username);

    public function save(User $user);

    public function delete(int $id);
}