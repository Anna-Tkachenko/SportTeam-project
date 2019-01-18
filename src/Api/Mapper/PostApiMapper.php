<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 0:02
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
            'author' => $post->getAuthor()
        ];
    }
}