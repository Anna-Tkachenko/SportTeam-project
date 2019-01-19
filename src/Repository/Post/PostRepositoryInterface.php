<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\Post;

use App\Entity\Post;

interface PostRepositoryInterface
{
    public function findByUser(string $slug);

    public function verifyPublished(string $username, $dateCreation);

    public function deletePost(int $id);

    public function save(Post $post);
}
