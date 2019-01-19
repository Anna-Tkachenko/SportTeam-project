<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 11:10
 */

namespace App\Service\User;


use App\Api\Document\DocumentBuilder;
use App\Api\Mapper\UserApiMapper;
use App\Dto\User;
use App\Exception\NullAttributeException;

class ApiUserService extends UserPage implements UserPageInterface
{
    public function create(array $data)
    {
        try{
            $user = parent::create($data['attributes']);
        } catch (NullAttributeException $e)
        {
            throw new \LogicException('You should declare all attributes.');
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }

    public function findOne(int $id)
    {
        $user =  parent::findOne($id);

        if(is_null($user)){
            return $user;
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }

    public function update(int $id, array $data)
    {
        $user =  parent::update($id, $data['attributes']);

        if(is_null($user)){
            return $user;
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }

}