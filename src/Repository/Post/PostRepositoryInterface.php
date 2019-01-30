<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\Post;

use App\Entity\Post;
use Doctrine\ORM\Query;

/**
 * Contract for post repository.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface PostRepositoryInterface
{
    /**
     * Gets posts for user page.
     *
     * @return Query
     */
    public function findByUser(string $slug, $postsId): Query;

    public function deletePost(int $id): void;

    /**
     * Saves post to database.
     */
    public function save(Post $post): void;
}
