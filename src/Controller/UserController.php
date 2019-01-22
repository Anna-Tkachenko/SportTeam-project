<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Service\Post\PostServiceInterface;
use App\Service\PostSharing\PostSharingServiceInterface;
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function __construct(PostServiceInterface $postService,
                                UserPageInterface $userPageService,
                                PostSharingServiceInterface $postSharingService)
    {
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

        $userPosts = $this->userPageService->getPosts($slug);

        return $this->render('user/index.html.twig', [
               'user' => $user,
               'current_user' => $currentUser,
                'userPosts' => $userPosts
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
            'current_user' => $currentUser
        ]);
    }

    /**
     * Show form for adding post.
     *
     * @Route("/user/{slug}/addPost", name="add_post")
     */
    public function addPost(Request $request, string $slug)
    {
        $userEntity = $this->userPageService->getUserEntity($slug);
        $currentUser = $this->getUser();
        $post = new Post($userEntity, $slug);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setDateCreation(new \DateTime());
            $this->postService->savePost($post);
            return $this->redirectToRoute('user', array('slug' => $slug));
        }

        return $this->render('user/settings/addPost.html.twig', [
            'current_user' => $currentUser,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/deletePost/{slug}", name="delete_post")
     */
    public function deletePost(int $slug)
    {
        $currentUser = $this->getUser();
        $post = $this->postService->findOne($slug);

        if($this->postSharingService->verifyPostSharingAbsent($currentUser, $post)){
            $this->postService->deletePost($slug);
        } else {
            $this->postSharingService->deletePostSharing($currentUser, $post);
        }

        $username = $currentUser->getUsername();

        $this->addFlash(
            'notice',
            'Post was deleted!'
        );

        return $this->redirectToRoute('user', ['slug' => $username]);
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
