<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Following\FollowServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    private $paginator;

    public function __construct(FollowServiceInterface $followService, PaginatorInterface $paginator)
    {
        $this->followService = $followService;
        $this->paginator = $paginator;
    }

    /**
     * Show all user followings.
     *
     * @Route("/user/{slug}/following", name="user_following")
     */
    public function showFollowing(string $slug, Request $request)
    {
        $followingQuery = $this->followService->getFollowing($slug);
        $currentUser = $this->getUser();

        $pagination = $this->paginator->paginate(
            $followingQuery,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('user/follow/showFollowing.html.twig', [
            'following' => $pagination,
            'current_user' => $currentUser,
        ]);
    }

    /**
     * Show all user followers.
     *
     * @Route("/user/{slug}/followers", name="user_followers")
     */
    public function showFollowers(string $slug, Request $request)
    {
        $followersQuery = $this->followService->getFollowers($slug);
        $currentUser = $this->getUser();

        $pagination = $this->paginator->paginate(
            $followersQuery,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('user/follow/showFollowers.html.twig', [
            'followers' => $pagination,
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
