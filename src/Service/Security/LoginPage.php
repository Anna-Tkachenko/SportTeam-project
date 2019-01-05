<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/4/19
 * Time: 12:57 PM
 */

namespace App\Service\Security;

use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginPage implements LoginPageInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function isValidUser(string $username, string $password, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if(is_null($user)){
            return false;
        } else {
            if($passwordEncoder->isPasswordValid($user, $password)){
                return true;
            } else {
                return false;
            }
        }
    }

}