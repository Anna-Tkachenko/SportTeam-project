<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            $entity->getLastName(),
            $entity->getImage(),
            $entity->getIsTrainer(),
            $entity->getIsPrivateFollowing(),
            $entity->getIsPrivateFollowers()
        );
    }
}
