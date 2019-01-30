<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\PostSharing;

use App\Entity\Post;
use App\Entity\PostSharing;
use App\Entity\User;

/**
 * Contract for post-sharing repository.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface PostSharingRepositoryInterface
{
    /**
     * Saves post-sharing to database.
     */
    public function save(PostSharing $postSharing): void;

    /**
     * Finds post-sharing by user and post.
     *
     * @return null|PostSharing
     */
    public function verifyShared(User $user, Post $post): ?PostSharing;

    public function delete(PostSharing $postSharing): void;

    public function getPostIdByUser(int $id);
}
