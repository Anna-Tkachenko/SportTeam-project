<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/16/19
 * Time: 5:40 PM
 */

namespace App\Controller;

use App\Service\User\UserPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserFollowController extends AbstractController
{
    /**
     * @Route("/user/{slug}/following", name="user_following")
     */
    public function showFollowing(string $slug, UserPageInterface $service)
    {
        $following = $service->getFollowing($slug);
        $currentUser = $service->getCurrentUser();

        return $this->render('user/follow/showFollowing.html.twig', [
            'following' => $following,
            'current_user' => $currentUser
        ]);
    }

    /**
     * @Route("/user/{slug}/followers", name="user_followers")
     */
    public function showFollowers(string $slug, UserPageInterface $service)
    {
        $followers = $service->getFollowers($slug);
        $currentUser = $service->getCurrentUser();

        return $this->render('user/follow/showFollowers.html.twig', [
            'followers' => $followers,
            'current_user' => $currentUser
        ]);
    }

    /**
     * @Route("/user/follow/{slug}", name="follow")
     */
    public function follow(string $slug, UserPageInterface $service)
    {
        $user = $service->getUserEntity($slug);
        $currentUser = $service->getCurrentUser();

        $currentUser->addFollowing($user);
        $user->addFollower($currentUser);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user', ['slug' => $slug]);
    }

    /**
     * @Route("/user/unfollow/{slug}", name="unfollow")
     */
    public function unfollow(string $slug, UserPageInterface $service)
    {
        $user = $service->getUserEntity($slug);
        $currentUser = $service->getCurrentUser();

        $currentUser->removeFollowing($user);
        $user->removeFollower($currentUser);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user', ['slug' => $slug]);
    }
}