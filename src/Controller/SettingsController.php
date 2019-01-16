<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/7/19
 * Time: 8:20 PM
 */

namespace App\Controller;


use App\Form\ChangeImageType;
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    /**
     * @Route("/user/{slug}/settings", name="settings")
     */
    public function index(UserPageInterface $service, Request $request)
    {
        $currentUser = $service->getCurrentUser();
        $form = $this->createForm(ChangeImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            #TODO: change user image
        }

        return $this->render('user/settings/index.html.twig', [
            'current_user' => $currentUser,
            'change_image_form' => $form->createView()
        ]);
    }

}