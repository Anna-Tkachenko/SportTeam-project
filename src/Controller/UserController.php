<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/3/19
 * Time: 6:31 PM
 */

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Service\Post\PostServiceInterface;
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $postService;
    private $userPageService;

    public function __construct(PostServiceInterface $postService, UserPageInterface $userPageService)
    {
        $this->postService = $postService;
        $this->userPageService = $userPageService;
    }

    /**
     * @Route("/user/{slug}", name="user")
     */
    public function index(string $slug)
    {
        $user = $this->userPageService->getUser($slug);
        $currentUser = $this->userPageService->getCurrentUser();
        $userPosts = $this->userPageService->getPosts($slug);

        $followStatus = $this->userPageService->getFollowStatus($currentUser->getUsername(), $slug);

        return $this->render('user/index.html.twig', [
               'user' => $user,
               'current_user' => $currentUser,
                'userPosts' => $userPosts,
                'follow_status' => $followStatus
           ]);
    }

    /**
     * @Route("/user/{slug}/allUsers", name="all_users")
     */
    public function showAll(string $slug)
    {
        $currentUser = $this->userPageService->getCurrentUser();
        $users =$this->userPageService->getAllUsers();

        return $this->render('user/showAll.html.twig', [
            'users' => $users,
            'current_user' => $currentUser
        ]);
    }

    /**
     * @Route("/user/{slug}/addPost", name="add_post")
     */
    public function addPost(Request $request, string $slug)
    {
        $faker = \Faker\Factory::create();
        $userEntity = $this->userPageService->getUserEntity($slug);
        $currentUser = $this->userPageService->getCurrentUser();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setIsPublished(true);
            $post->setUser($userEntity);
            $post->setAuthor($slug);
            $post->setDateCreation($faker->dateTime);

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
        $this->postService->deletePost($slug);
        $username = $this->userPageService->getCurrentUser()->getUsername();

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
        $currentUser = $this->userPageService->getCurrentUser();
        $sharedPost = $this->postService->getPost($slug);

        if($this->userPageService->verifyPostAdding($currentUser->getUsername(), $sharedPost->getDateCreation())){

            $this->postService->sharePost($sharedPost, $currentUser);
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