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

class UserController extends AbstractController
{

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
}