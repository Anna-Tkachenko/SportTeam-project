<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 15:58
 */

namespace App\Service\PostSharing;


use App\Entity\Post;
use App\Entity\User;

interface PostSharingServiceInterface
{
    public function share(User $user, Post $post): void;

    public function verifyPostSharingAbsent(User $user, Post $post): bool;

    public function deletePostSharing(User $user, Post $post): void;
}