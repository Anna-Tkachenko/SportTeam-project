<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 18.01.19
 * Time: 22:34
 */

namespace App\Service\Post;


use App\Api\Mapper\ApiMapperInterface;
use App\Api\Document\DocumentBuilder;
use App\Api\Mapper\PostApiMapper;
use App\Exception\NullAttributeException;

class ApiPostService extends PostService implements PostServiceInterface
{
    public function create(array $data)
    {
        try{
            $post = parent::create($data['attributes']);
        } catch (NullAttributeException $e)
        {
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

        if(is_null($post)){
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

        if(is_null($post)){
            return $post;
        }

        return  DocumentBuilder::getInstance(new PostApiMapper())
            ->setEntity($post)
            ->getDocument()
            ;
    }

}