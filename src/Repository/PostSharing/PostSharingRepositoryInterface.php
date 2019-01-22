<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 16:01
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
}