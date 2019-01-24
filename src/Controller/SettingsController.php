<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Dto\ChangePassword;
use App\Form\ChangePasswordType;
use App\Form\UserInfoType;
use App\Service\Settings\SettingsServiceInterface;
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
    private $settingsService;

    public function __construct(
        SettingsServiceInterface $settingsService
    ) {
        $this->settingsService = $settingsService;
    }

    /**
     * @Route("/user/{slug}/settings/change_profile", name="change_profile")
     */
    public function index(Request $request)
    {
        $currentUser = $this->getUser();
        $userInfo = $this->settingsService->getData($currentUser);

        $form = $this->createForm(UserInfoType::class, $userInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectDir = $this->getParameter('kernel.project_dir');
            $currentUser = $this->settingsService->setData($currentUser, $userInfo, $projectDir);

            return $this->redirectToRoute('user', ['slug' => $currentUser->getUsername()]);
        }

        return $this->render('user/settings/index.html.twig', [
            'current_user' => $currentUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{slug}/settings/change_password", name="change_password")
     */
    public function changePassword(Request $request)
    {
        $currentUser = $this->getUser();

        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->settingsService->changePassword($currentUser, $changePassword->getNewPassword());

            return $this->redirectToRoute('user', ['slug' => $currentUser->getUsername()]);
        }

        return $this->render('user/settings/changePassword.html.twig', [
            'current_user' => $currentUser,
            'form' => $form->createView(),
        ]);
    }
}
