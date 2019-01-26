<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Settings;

use App\Dto\UserDto;
use App\Entity\User;

interface SettingsServiceInterface
{
    public function getDto(User $user): UserDto;

    public function updateData(User $user, UserDto $userDto): User;

    public function changePassword(User $user, $newPassword): User;
}
