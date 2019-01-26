<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 26.01.19
 * Time: 17:10
 */

namespace App\Listener;


use App\Repository\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class UserListener extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetResponseEvent $event)
    {
        $user = $this->getUser();
        if(!empty($user)){
            $user->setLastActiveAt(new \DateTime());
            $this->userRepository->save($user);
        }

    }
}