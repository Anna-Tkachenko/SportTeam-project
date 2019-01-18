<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/8/19
 * Time: 7:51 PM
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