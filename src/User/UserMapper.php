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
use App\Dto\UserDto as UserDtoObject;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserMapper
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

    /**
     * Maps user DTO to user entity.
     *
     * @param UserDto $dto DTO to map.
     *
     * @return User Mapped new user entity.
     */
    public function dtoToEntity(UserDtoObject $dto, UserPasswordEncoderInterface $passwordEncoder): User
    {
        $user = new User();
        $user->setUsername($dto->getUsername());
        $user->setFirstName($dto->getFirstName());
        $user->setLastName($dto->getLastName());
        $user->setPassword($passwordEncoder->encodePassword($user, $dto->getPassword()));
        $user->setEmail($dto->getEmail());
        $user->setIsActive($dto->isActive());
        $user->setIsTrainer($dto->isTrainer());
        return $user;
    }
}
