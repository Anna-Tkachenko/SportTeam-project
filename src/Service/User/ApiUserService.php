<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Api\Document\DocumentBuilder;
use App\Api\Mapper\UserApiMapper;
use App\Exception\NullAttributeException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides user resource for using in API.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class ApiUserService extends UserPage implements UserPageInterface
{
    public function create(Request $request)
    {
        try {
            $user = parent::create($request);
        } catch (NullAttributeException $e) {
            throw new \LogicException('You should declare all attributes.');
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }

    public function findOne($id)
    {
        $user =  parent::findOne($id);

        if (null === $user) {
            return $user;
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }

    public function update($id, array $data)
    {
        $user =  parent::update($id, $data['attributes']);

        if (null === $user) {
            return $user;
        }

        return  DocumentBuilder::getInstance(new UserApiMapper())
            ->setEntity($user)
            ->getDocument()
            ;
    }
}
