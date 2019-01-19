<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Dto\Post;
use App\Entity\User;
use App\Exception\NullAttributeException;
use App\Post\PostMapper;
use App\Post\PostsCollection;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\User\UserMapper;
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

    public function __construct(
        UserRepositoryInterface $userRepository,
                                PostRepositoryInterface $postRepository,
                                Security $security,
                                UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->postRepository = $postRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCurrentUser()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
        return $user;
    }

    public function getUser(string $slug)
    {
        $user = $this->userRepository->findOneBy(['username' => $slug]);
        $dataMapper = new UserMapper();
        $currentUser = $dataMapper->entityToDto($user);
        return $currentUser;
    }

    public function getUserEntity(string $slug)
    {
        $user = $this->userRepository->findOneBy(['username' => $slug]);
        return $user;
    }

    public function getPosts(string $slug)
    {
        $posts = $this->postRepository->findByUser($slug);
        $collection = new PostsCollection();
        $dataMapper = new PostMapper();
        foreach ($posts as $post) {
            $collection->addPost($dataMapper->entityToDto($post));
        }
        return $collection;
    }

    public function verifyPostAdding(string $username, $datetime)
    {
        if ($this->postRepository->verifyPublished($username, $datetime) != []) {
            return false;
        }

        return true;
    }

    public function getFollowers(string $slug)
    {
        $user = $this->getUserEntity($slug);
        return $user->getFollowers();
    }

    public function getFollowing(string $slug)
    {
        $user = $this->getUserEntity($slug);
        return $user->getFollowing();
    }

    public function getFollowStatus(string $currentUsername, string $selectUsername)
    {
        //1- if currentUser doesn't follow on selectUser
        //2 - if currentUser follows on selectUser
        //3 - if currentUser is selectUser

        if ($currentUsername == $selectUsername) {
            return '3';
        }

        $following = $this->getFollowing($currentUsername);

        foreach ($following as $user) {
            if ($selectUsername == $user->getUsername()) {
                return '2';
            }
        }

        return '1';
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }

    public function create(array $data)
    {
        if (isset($data['username']) && isset($data['first_name']) && isset($data['last_name'])
            && isset($data['plain_password']) && isset($data['email']) && isset($data['is_active'])) {
        } else {
            throw new NullAttributeException();
        }

        $user = new User();
        $user->setUsername($data['username']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setPlainPassword($data['plain_password']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $data['plain_password']));
        $user->setEmail($data['email']);
        $user->setIsActive($data['is_active']);

        $this->userRepository->save($user);

        return $user;
    }

    public function findOne(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
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

    public function deleteUser(int $id)
    {
        $this->userRepository->delete($id);
    }
}
