<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/8/19
 * Time: 7:57 PM
 */

namespace App\Post;

use App\Entity\Post;
use App\Dto\Post as PostDto;

class PostMapper
{
    /**
     * Maps post entity to DTO.
     *
     * @param Post $entity Entity to map.
     *
     * @return PostDto Mapped new user DTO.
     */
    public function entityToDto(Post $entity): PostDto
    {
        return new PostDto(
            $entity->getId(),
            $entity->getName(),
            $entity->getContent(),
            $entity->getIsPublished(),
            $entity->getDateCreation(),
            $entity->getAuthor()
        );
    }
}