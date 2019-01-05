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
}