<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Api\Mapper\ApiMapperInterface;
use App\Service\User\UserPageInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API endpoint for user resource.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class UserController extends AbstractFOSRestController
{
    private $service;
    private $postMapper;

    public function __construct(UserPageInterface $service, ApiMapperInterface $userMapper)
    {
        $this->service = $service;
        $this->postMapper = $userMapper;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function postUser(Request $request)
    {
        $user = $this->service->create($request);

        return $this->view($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/api/user/{id}")
     */
    public function getUserr(int $id)
    {
        $user = $this->service->findOne($id);

        if (null === $user) {
            return $this->view([], Response::HTTP_NOT_FOUND);
        }

        return $this->view($user, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/api/user/{id}")
     */
    public function patchUser(int $id, Request $request)
    {
        $user = $this->service->update($id, $request->request->get('data'));

        return $this->view($user, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/user/{id}")
     */
    public function deleteUser(int $id)
    {
        $this->service->deleteUser($id);

        return $this->view([], Response::HTTP_NO_CONTENT);
    }
}
