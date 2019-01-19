<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
