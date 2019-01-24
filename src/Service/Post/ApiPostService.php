<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Post;

use App\Api\Document\DocumentBuilder;
use App\Api\Mapper\PostApiMapper;
use App\Exception\NullAttributeException;

/**
 * Provides post resource for using in API.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class ApiPostService extends PostService implements PostServiceInterface
{
    public function create(array $data)
    {
        try {
            $post = parent::create($data['attributes']);
        } catch (NullAttributeException $e) {
            throw new \LogicException('You should declare all attributes.');
        }

        return  DocumentBuilder::getInstance(new PostApiMapper())
        ->setEntity($post)
        ->getDocument()
        ;
    }

    public function findOne(int $id)
    {
        $post =  parent::findOne($id);

        if (null === $post) {
            return $post;
        }

        return  DocumentBuilder::getInstance(new PostApiMapper())
            ->setEntity($post)
            ->getDocument()
            ;
    }

    public function update(int $id, array $data)
    {
        $post =  parent::update($id, $data['attributes']);

        if (null === $post) {
            return $post;
        }

        return  DocumentBuilder::getInstance(new PostApiMapper())
            ->setEntity($post)
            ->getDocument()
            ;
    }
}
