<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\PostSharing;

use App\Entity\Post;
use App\Entity\User;

/**
 * Contract for post sharing service.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface PostSharingServiceInterface
{
    public function share(User $user, Post $post): void;

    public function verifyPostSharingAbsent(User $user, Post $post): bool;

    public function deletePostSharing(User $user, Post $post): void;
}
