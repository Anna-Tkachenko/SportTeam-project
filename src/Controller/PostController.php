<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 21.01.19
 * Time: 16:02
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

class PostController extends AbstractController
{
    private $userPageService;
    private $postService;
    private $postSharingService;

    public function __construct(
        UserPageInterface $userPageService,
        PostServiceInterface $postService,
        PostSharingServiceInterface $postSharingService
    )
    {
        $this->userPageService = $userPageService;
        $this->postService = $postService;
        $this->postSharingService = $postSharingService;
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
}