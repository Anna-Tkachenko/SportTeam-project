<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 6:56 PM
 */

namespace App\User;

use App\Entity\User;
use App\Dto\User as UserDto;

class UserMapper
{
    /**
     * Maps user entity to DTO.
     *
     * @param User $entity Entity to map.
     *
     * @return UserDto Mapped new user DTO.
     */
    public function entityToDto(User $entity): UserDto
    {
        return new UserDto(
            $entity->getUsername(),
            $entity->getPassword(),
            $entity->getEmail(),
            $entity->getIsActive(),
            $entity->getFirstName(),
            $entity->getLastName()
        );
    }
}