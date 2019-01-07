<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/7/19
 * Time: 8:20 PM
 */

namespace App\Controller;


use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingsController extends AbstractController
{
    public function index(UserPageInterface $service)
    {
        $currentUser = $service->getCurrentUser();
        return $this->render('user/settings/index.html.twig', [
            'currentUser' => $currentUser
        ]);
    }

}