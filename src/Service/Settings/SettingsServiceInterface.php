<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 23.01.19
 * Time: 14:58
 */

namespace App\Service\Settings;


use App\Dto\UserInfo;
use App\Entity\User;

interface SettingsServiceInterface
{
    public function getData(User $user): UserInfo;

    public function setData(User $user, UserInfo $userInfo, $projectDir): User;

    public function changePassword(User $user, $newPassword): User;

    public function saveUser(User $user): void;
}