<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 3:39 PM
 */

namespace App\Service\User;

use App\Repository\User\UserRepositoryInterface;
use App\User\UserMapper;
use Symfony\Component\Security\Core\Security;

class UserPage implements UserPageInterface
{
    private $userRepository;
    private $security;

    public function __construct(UserRepositoryInterface $userRepository, Security $security) {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function getUser(string $slug) {
        $user = $this->userRepository->findOneBy(['username' => $slug]);
        $dataMapper = new UserMapper();
        $currentUser = $dataMapper->entityToDto($user);
        return $currentUser;
    }

    public function getCurrentUser()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
        return $user;
    }


}