<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 23:09
 */

namespace App\Service\Following;


use App\Repository\User\UserRepositoryInterface;
use App\Service\Following\FollowServiceInterface;

class FollowService implements FollowServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function follow($currentUser, $user)
    {
        $currentUser->addFollowing($user);
        $user->addFollower($currentUser);
        $this->saveUser($user);
        $this->saveUser($currentUser);
    }

    public function unFollow($currentUser, $user)
    {
        $currentUser->removeFollowing($user);
        $user->removeFollower($currentUser);
        $this->saveUser($user);
        $this->saveUser($currentUser);
    }

    public function getFollowing(string $slug)
    {
        $user = $this->getUserEntity($slug);
        return $user->getFollowing();
    }

    public function getFollowers(string $slug)
    {
        $user = $this->getUserEntity($slug);
        return $user->getFollowers();
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

    public function saveUser($user)
    {
        $this->userRepository->save($user);
    }

    public function getUserEntity(string $slug)
    {
        return $this->userRepository->findOneBy(['username' => $slug]);
    }

}