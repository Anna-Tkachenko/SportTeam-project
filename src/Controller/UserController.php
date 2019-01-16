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
use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user")
     */
    public function show(UserPageInterface $service, string $slug)
    {
        $user = $service->getUser($slug);
        $currentUser = $service->getCurrentUser();
        $userPosts = $service->getPosts($slug);

        return $this->render('user/index.html.twig', [
               'user' => $user,
               'currentUser' => $currentUser,
                'userPosts' => $userPosts
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
            $post->setAuthor($currentUser->getUsername());
            $post->setDateCreation($faker->dateTime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('user', array('slug' => $slug));
        }

        return $this->render('user/settings/addPost.html.twig', [
            'currentUser' => $currentUser,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/deletePost/{slug}", name="delete_post")
     */
    public function deletePost(string $slug, UserPageInterface $service)
    {
        $post = $service->getPost($slug);
        $username = $service->getCurrentUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

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
            $post = new Post();
            $post->setName($sharedPost->getName());
            $post->setContent($sharedPost->getContent());
            $post->setIsPublished(true);
            $post->setUser($currentUser);
            $post->setAuthor($sharedPost->getAuthor());
            $post->setDateCreation($sharedPost->getDateCreation());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

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