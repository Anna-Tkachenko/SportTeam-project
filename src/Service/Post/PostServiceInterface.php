<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 18.01.19
 * Time: 22:34
 */

namespace App\Service\Post;


use App\Entity\Post;
use App\Entity\User;

interface PostServiceInterface
{
    public function deletePost(int $id): void;

    public function sharePost(Post $sharedPost, User $user);

    public function savePost(Post $post);

    public function create(array $data);

    public function findOne(int $id);

    public function update(int $id, array $data);
}