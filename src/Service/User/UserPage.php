<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 3:39 PM
 */

namespace App\Service\User;

use App\Post\PostMapper;
use App\Post\PostsCollection;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\User\UserMapper;
use Symfony\Component\Security\Core\Security;

class UserPage implements UserPageInterface
{
    private $userRepository;
    private $postRepository;
    private $security;

    public function __construct(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository, Security $security) {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->postRepository = $postRepository;
    }

    public function getUser(string $slug) {
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

    public function getCurrentUser()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
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

}