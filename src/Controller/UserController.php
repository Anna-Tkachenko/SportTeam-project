<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 6:31 PM
 */

namespace App\Controller;

use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    public function show(UserPageInterface $service, string $slug)
    {
        $user = $service->getUser($slug);
        $currentUser = $service->getCurrentUser();

        return $this->render('user/index.html.twig', [
               'user' => $user,
               'currentUser' => $currentUser
           ]);
    }
}