<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\ChangeImageType;
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller provides user settings page.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class SettingsController extends AbstractController
{
    private $userPageService;

    public function __construct(UserPageInterface $userPageService)
    {
        $this->userPageService = $userPageService;
    }

    /**
     * @Route("/user/{slug}/settings", name="settings")
     */
    public function index(Request $request)
    {
        $currentUser = $this->getUser();
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
