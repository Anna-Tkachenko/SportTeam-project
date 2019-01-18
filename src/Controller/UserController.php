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

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @Route("/user/{slug}", name="user")
     */
    public function index(UserPageInterface $service, string $slug)
    {
        $user = $service->getUser($slug);
        $currentUser = $service->getCurrentUser();
        $userPosts = $service->getPosts($slug);

        $followStatus = $service->getFollowStatus($currentUser->getUsername(), $slug);

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
    public function showAll(UserPageInterface $service, string $slug)
    {
        $currentUser = $service->getCurrentUser();
        $users = $service->getAllUsers();

        return $this->render('user/showAll.html.twig', [
            'users' => $users,
            'current_user' => $currentUser
        ]);
    }

    /**
     * @Route("/user/{slug}/addPost", name="add_post")
     */
    public function addPost(Request $request, string $slug, UserPageInterface $service)
    {
        $faker = \Faker\Factory::create();
        $userEntity = $service->getUserEntity($slug);
        $currentUser = $service->getCurrentUser();
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
    public function deletePost(int $slug, UserPageInterface $service)
    {
        $this->postService->deletePost($slug);
        $username = $service->getCurrentUser()->getUsername();

        $this->addFlash(
            'notice',
            'Post was deleted!'
        );

        return $this->redirectToRoute('user', ['slug' => $username]);
    }

    /**
     * @Route("/user/sharePost/{slug}", name="share_post")
     */
    public function sharePost(string $slug, UserPageInterface $service)
    {
        $currentUser = $service->getCurrentUser();
        $sharedPost = $service->getPost($slug);

        if($service->verifyPostAdding($currentUser->getUsername(), $sharedPost->getDateCreation())){

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