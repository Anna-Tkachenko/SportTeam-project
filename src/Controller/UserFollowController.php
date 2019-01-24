<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Following\FollowServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller provides user followers and followings pages,
 * follow, unfollow functions.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class UserFollowController extends AbstractController
{
    private $followService;

    public function __construct(FollowServiceInterface $followService)
    {
        $this->followService = $followService;
    }

    /**
     * Show all user followings.
     *
     * @Route("/user/{slug}/following", name="user_following")
     */
    public function showFollowing(string $slug)
    {
        $following = $this->followService->getFollowing($slug);
        $currentUser = $this->getUser();

        return $this->render('user/follow/showFollowing.html.twig', [
            'following' => $following,
            'current_user' => $currentUser,
        ]);
    }

    /**
     * Show all user followers.
     *
     * @Route("/user/{slug}/followers", name="user_followers")
     */
    public function showFollowers(string $slug)
    {
        $followers = $this->followService->getFollowers($slug);
        $currentUser = $this->getUser();

        return $this->render('user/follow/showFollowers.html.twig', [
            'followers' => $followers,
            'current_user' => $currentUser,
        ]);
    }

    /**
     * @Route("/user/follow/{slug}", name="follow")
     */
    public function follow(string $slug)
    {
        $user = $this->followService->getUserEntity($slug);
        $currentUser = $this->getUser();
        $this->followService->follow($currentUser, $user);

        return $this->redirectToRoute('user', ['slug' => $slug]);
    }

    /**
     * @Route("/user/unfollow/{slug}", name="unfollow")
     */
    public function unfollow(string $slug)
    {
        $user = $this->followService->getUserEntity($slug);
        $currentUser = $this->getUser();
        $this->followService->unFollow($currentUser, $user);

        return $this->redirectToRoute('user', ['slug' => $slug]);
    }
}
