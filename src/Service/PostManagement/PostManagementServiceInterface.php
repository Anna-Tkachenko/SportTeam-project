<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\PostManagement;

use App\Dto\PostType;
use App\Entity\Post;

interface PostManagementServiceInterface
{
    public function setData(Post $post, PostType $postType, $projectDir): Post;

    public function getData(Post $post): PostType;

    public function save(Post $post): void;
}
