<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 23.01.19
 * Time: 20:30
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