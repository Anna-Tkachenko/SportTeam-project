<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Post\PostServiceInterface;
use App\Service\PostSharing\PostSharingServiceInterface;
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller provides user pages.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class UserController extends AbstractController
{
    private $postService;
    private $userPageService;
    private $postSharingService;

    public function __construct(
        PostServiceInterface $postService,
                                UserPageInterface $userPageService,
                                PostSharingServiceInterface $postSharingService
    ) {
        $this->postService = $postService;
        $this->userPageService = $userPageService;
        $this->postSharingService = $postSharingService;
    }

    /**
     * @Route("/user/{slug}", name="user")
     */
    public function index(string $slug)
    {
        $currentUser = $this->getUser();
        $user = $this->userPageService->getUser($currentUser, $slug);

        $userPosts = $this->postService->getPosts($slug);

        return $this->render('user/index.html.twig', [
               'user' => $user,
               'current_user' => $currentUser,
                'userPosts' => $userPosts,
           ]);
    }

    /**
     * Show all registered users.
     *
     * @Route("/user/{slug}/allUsers", name="all_users")
     */
    public function showAll(string $slug)
    {
        $currentUser = $this->getUser();
        $users =$this->userPageService->getAllUsers();

        return $this->render('user/showAll.html.twig', [
            'users' => $users,
            'current_user' => $currentUser,
        ]);
    }

    /**
     * @Route("/user/sharePost/{slug}", name="share_post")
     */
    public function sharePost(string $slug)
    {
        $currentUser = $this->getUser();
        $sharedPost = $this->postService->getPost($slug);

        if ($this->postSharingService->verifyPostSharingAbsent($currentUser, $sharedPost)) {
            $this->postSharingService->share($currentUser, $sharedPost);

            $this->addFlash(
                'notice',
                'Post was added!'
            );
        } else {
            $this->addFlash(
                'notice',
                'Post is already on your page!'
            );
        }

        return $this->redirectToRoute('user', ['slug' => $currentUser->getUsername()]);
    }
}
