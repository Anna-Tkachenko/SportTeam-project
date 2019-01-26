<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Post;
use App\Exception\PostNotFoundException;
use App\Form\PostType;
use App\Dto\PostType as PostModel;
use App\Service\Post\PostServiceInterface;
use App\Service\PostManagement\PostManagementServiceInterface;
use App\Service\PostSharing\PostSharingServiceInterface;
use App\Service\User\UserPageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller provides post management functions.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class PostController extends AbstractController
{
    private $userPageService;
    private $postService;
    private $postSharingService;
    private $postManagementService;

    public function __construct(
        UserPageInterface $userPageService,
        PostServiceInterface $postService,
        PostSharingServiceInterface $postSharingService,
        PostManagementServiceInterface $postManagementService
    ) {
        $this->userPageService = $userPageService;
        $this->postService = $postService;
        $this->postSharingService = $postSharingService;
        $this->postManagementService = $postManagementService;
    }

    /**
     * Provide add post function.
     *
     * @IsGranted("ROLE_USER_TRAINER")
     *
     * @Route("/user/{slug}/add_post", name="add_post")
     */
    public function addPost(Request $request, string $slug)
    {
        $userEntity = $this->userPageService->getUserEntity($slug);
        $post = new Post($userEntity, $slug);
        $postType = new PostModel();

        return $this->getResponse($request, $postType, $post);
    }

    /**
     * Provide edit post function.
     *
     * @IsGranted("ROLE_USER_TRAINER")
     *
     * @Route("/user/{slug}/edit_post/{postId}/", name="edit_post")
     */
    public function editPost(Request $request, string $slug, int $postId)
    {
        try {
            $post = $this->postService->findOne($postId);
        } catch (PostNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $postType = $this->postManagementService->getData($post);

        return $this->getResponse($request, $postType, $post);
    }

    /**
     * Show form for add/edit post functions.
     */
    private function getResponse(Request $request, $postType, $post)
    {
        $currentUser = $this->getUser();
        $form = $this->createForm(PostType::class, $postType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectDir = $this->getParameter('kernel.project_dir');
            $post = $this->postManagementService->setData($post, $postType, $projectDir);

            return $this->redirectToRoute('user', ['slug' => $currentUser->getUsername()]);
        }

        return $this->render('user/settings/addPost.html.twig', [
            'current_user' => $currentUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/deletePost/{slug}", name="delete_post")
     */
    public function deletePost(int $slug)
    {
        $currentUser = $this->getUser();
        $post = $this->postService->findOne($slug);

        if ($this->postSharingService->verifyPostSharingAbsent($currentUser, $post)) {
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
}
