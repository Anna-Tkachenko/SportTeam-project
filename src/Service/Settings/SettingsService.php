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
use App\Repository\User\UserRepositoryInterface;
use App\Service\FileSystem\FileManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SettingsService implements SettingsServiceInterface
{
    private $userRepository;
    private $fileManager;
    private $passwordEncoder;
    private $projectUploadsDir;

    public function __construct(
        $projectUploadsDir,
        UserRepositoryInterface $userRepository,
        FileManagerInterface $fileManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->fileManager = $fileManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->projectUploadsDir = $projectUploadsDir;
    }

    public function getDto(User $user): UserDto
    {
        $userDto = new UserDto();
        $userDto->setFirstName($user->getFirstName());
        $userDto->setLastName($user->getLastName());
        $userDto->setIsPrivateFollowing($user->getIsPrivateFollowing());
        $userDto->setIsPrivateFollowers($user->getIsPrivateFollowers());

        return $userDto;
    }

    public function updateData(User $user, UserDto $userDto): User
    {
        $user->setFirstName($userDto->getFirstName());
        $user->setLastName($userDto->getLastName());
        $user->setIsPrivateFollowing($userDto->getIsPrivateFollowing());
        $user->setIsPrivateFollowers($userDto->getIsPrivateFollowers());

        if (null != $userDto->getImage()) {
            if (null != $user->getImage()) {
                $oldFilePath = $this->projectUploadsDir . $user->getImage();
                unlink($oldFilePath);
            }
            $fileName = $this->fileManager->upload($userDto->getImage());
            $user->setImage($fileName);
        }

        $this->userRepository->save($user);

        return $user;
    }

    public function changePassword(User $user, $newPassword): User
    {
        $password = $this->passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($password);
        $this->userRepository->save($user);

        return $user;
    }
}
