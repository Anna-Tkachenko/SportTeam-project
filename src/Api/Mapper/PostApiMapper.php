<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Mapper;

final class PostApiMapper implements ApiMapperInterface
{
    public function getType(): string
    {
        return 'post';
    }

    public function getAttributes($post): iterable
    {
        return [
            'id' => $post->getId(),
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'is_published' => $post->getIsPublished(),
            'date_creation' => $post->getDateCreation(),
            'author' => $post->getAuthor(),
        ];
    }
}
