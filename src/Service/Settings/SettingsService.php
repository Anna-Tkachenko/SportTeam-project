<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Settings;

use App\Dto\UserInfo;
use App\Entity\User;
use App\Service\FileSystem\FileManagerInterface;
use App\Service\User\UserPageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SettingsService implements SettingsServiceInterface
{
    private $userPageService;
    private $fileManager;
    private $passwordEncoder;

    public function __construct(
        UserPageInterface $userPageService,
        FileManagerInterface $fileManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userPageService = $userPageService;
        $this->fileManager = $fileManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getData(User $user): UserInfo
    {
        $userInfo = new UserInfo();
        $userInfo->setFirstName($user->getFirstName());
        $userInfo->setLastName($user->getLastName());

        return $userInfo;
    }

    public function setData(User $user, UserInfo $userInfo, $projectDir): User
    {
        $user->setFirstName($userInfo->getFirstName());
        $user->setLastName($userInfo->getLastName());

        if (null != $userInfo->getImage()) {
            if ($user->getImage() != null) {
                $oldFilePath = $projectDir.'/public/uploads/'.$user->getImage();
                unlink($oldFilePath);
            }
            $fileName = $this->fileManager->upload($userInfo->getImage());
            $user->setImage($fileName);
        }

        $this->saveUser($user);

        return $user;
    }

    public function changePassword(User $user, $newPassword): User
    {
        $password = $this->passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($password);
        $this->saveUser($user);

        return $user;
    }

    public function saveUser(User $user): void
    {
        $this->userPageService->save($user);
    }
}
