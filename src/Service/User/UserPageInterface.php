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
}