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
use App\Dto\PostType as PostModel;
use App\Service\Post\PostServiceInterface;
use App\Service\PostManagement\PostManagementServiceInterface;
use App\Service\PostSharing\PostSharingServiceInterface;
use App\Service\User\UserPageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    )
    {
        $this->userPageService = $userPageService;
        $this->postService = $postService;
        $this->postSharingService = $postSharingService;
        $this->postManagementService = $postManagementService;
    }

    /**
     * Show form for adding/editing post.
     *
     * @IsGranted("ROLE_USER_TRAINER")
     *
     * @Route("/user/{slug}/post/{postId}/{option}", name="add_post")
     */
    public function addPost(Request $request, string $slug, int $postId, string $option)
    {
        if($option == 'add') {
            $userEntity = $this->userPageService->getUserEntity($slug);
            $post = new Post($userEntity, $slug);
            $postType = new PostModel();
        } elseif ($option == 'edit') {
            $post = $this->postService->findOne($postId);
            $postType = $this->postManagementService->getData($post);
        }

        $currentUser = $this->getUser();
        $form = $this->createForm(PostType::class, $postType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $projectDir = $this->getParameter('kernel.project_dir');
            $post = $this->postManagementService->setData($post, $postType, $projectDir);

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