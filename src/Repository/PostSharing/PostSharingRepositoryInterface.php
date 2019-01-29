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

interface PostSharingRepositoryInterface
{
    public function save(PostSharing $postSharing): void;

    public function verifyShared(User $user, Post $post);

    public function delete(PostSharing $postSharing): void;

    public function getIdByUser(int $id);
}
