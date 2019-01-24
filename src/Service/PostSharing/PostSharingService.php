<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\PostSharing;

use App\Entity\Post;
use App\Entity\PostSharing;
use App\Entity\User;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\PostSharing\PostSharingRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;

class PostSharingService implements PostSharingServiceInterface
{
    private $userRepository;
    private $postRepository;
    private $postSharingRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PostRepositoryInterface $postRepository,
        PostSharingRepositoryInterface $postSharingRepository
    ) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->postSharingRepository = $postSharingRepository;
    }

    public function share(User $user, Post $post): void
    {
        $sharing = new PostSharing();
        $sharing->setPost($post);
        $sharing->setUser($user);
        $this->postSharingRepository->save($sharing);
    }

    public function verifyPostSharingAbsent(User $user, Post $post): bool
    {
        if ($this->postSharingRepository->verifyShared($user, $post) != []) {
            return false;
        }

        return true;
    }

    public function deletePostSharing(User $user, Post $post): void
    {
        $sharing = $this->postSharingRepository->verifyShared($user, $post);

        if ($sharing != []) {
            $this->postSharingRepository->delete($sharing);
        }
    }
}
