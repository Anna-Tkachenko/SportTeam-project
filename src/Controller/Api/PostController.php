<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Api\Mapper\ApiMapperInterface;
use App\Service\Post\PostServiceInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API endpoint for post resource.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class PostController extends AbstractFOSRestController
{
    private $service;
    private $postMapper;

    public function __construct(PostServiceInterface $service, ApiMapperInterface $postMapper)
    {
        $this->service = $service;
        $this->postMapper = $postMapper;
    }

    /**
     * @Rest\Post("/api/post")
     */
    public function postPost(Request $request)
    {
        $post = $this->service->create($request->request->get('data'));
        return $this->view($post, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/api/post/{id}")
     */
    public function getPost(int $id)
    {
        $post = $this->service->findOne($id);

        if (null === $post) {
            return $this->view([], Response::HTTP_NOT_FOUND);
        }

        return $this->view($post, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/api/post/{id}")
     */
    public function patchPost(int $id, Request $request)
    {
        $post = $this->service->update($id, $request->request->get('data'));
        return $this->view($post, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/post/{id}")
     */
    public function deletePost(int $id)
    {
        $this->service->deletePost($id);
        return $this->view([], Response::HTTP_NO_CONTENT);
    }
}
