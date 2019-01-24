<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Mapper;

final class UserApiMapper implements ApiMapperInterface
{
    public function getType(): string
    {
        return 'user';
    }

    public function getAttributes($user): iterable
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'is_active' => $user->getIsActive(),
        ];
    }
}
