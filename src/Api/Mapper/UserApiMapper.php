<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 11:34
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
            'is_active' => $user->getIsActive()
        ];
    }
}