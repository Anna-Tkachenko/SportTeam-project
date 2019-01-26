<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Post;

use App\Entity\Post;
use App\Post\PostsCollection;

/**
 * Contract for post service.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface PostServiceInterface
{
    public function deletePost(int $id): void;

    public function create(array $data);

    public function findOne(int $id);

    public function update(int $id, array $data);

    public function getPost(string $slug);

    public function getPosts(string $slug): PostsCollection;
}
