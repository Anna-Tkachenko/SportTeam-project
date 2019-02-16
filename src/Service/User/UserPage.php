<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Dto\User as DtoUser;
use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\Service\Following\FollowServiceInterface;
use App\User\UserMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Service provides user data from the storage.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class UserPage implements UserPageInterface
{
    private $userRepository;
    private $postRepository;
    private $security;
    private $passwordEncoder;
    private $followService;

    public function __construct(
                                UserRepositoryInterface $userRepository,
                                PostRepositoryInterface $postRepository,
                                Security $security,
                                UserPasswordEncoderInterface $passwordEncoder,
                                FollowServiceInterface $followService
    ) {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->postRepository = $postRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->followService = $followService;
    }

    public function getCurrentUser()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();

        return $user;
    }

    public function getUser($currentUser, $slug)
    {
        $user = $this->userRepository->findOneBy(['username' => $slug]);
        $dataMapper = new UserMapper();
        $user = $dataMapper->entityToDto($user);
        $followStatus = $this->getFollowStatus($currentUser->getUsername(), $slug);
        $user->setFollowStatus($followStatus);

        return $user;
    }

    public function getUserEntity($slug): User
    {
        $user = $this->userRepository->findOneBy(['username' => $slug]);

        return $user;
    }

    public function getAllUsers()
    {
        return $this->userRepository->loadAllUsers();
    }

    public function create(Request $request)
    {
        $userDto = new UserDto();
        $userMapper = new UserMapper();
        $userDto = $userDto->fromRequest($request);
        $user = $userMapper->dtoToEntity($userDto, $this->passwordEncoder);
        $this->userRepository->save($user);

        return $user;
    }

    public function findOne($id)
    {
        return $this->userRepository->find($id);
    }

    public function update($id, array $data)
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $user;
        }

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['first_name'])) {
            $user->setFirstName($data['first_name']);
        }

        if (isset($data['last_name'])) {
            $user->setLastName($data['last_name']);
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $user->setIsActive($data['is_active']);
        }

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['password'])) {
            $user->setPassword($this->passwordEncoder->encodePassword($data['password']));
        }

        $this->userRepository->save($user);

        return $user;
    }

    public function deleteUser($id): void
    {
        $this->userRepository->delete($id);
    }

    private function getFollowStatus(string $currentUsername, string $selectUsername)
    {
        if ($currentUsername == $selectUsername) {
            return DtoUser::IS_THE_SAME;
        }

        $followings = $this->followService->getFollowing($currentUsername)->getResult();

        foreach ($followings as $user) {
            if ($selectUsername == $user->getUsername()) {
                return DtoUser::IS_FOLLOW;
            }
        }

        return DtoUser::IS_NOT_FOLLOW;
    }
}
