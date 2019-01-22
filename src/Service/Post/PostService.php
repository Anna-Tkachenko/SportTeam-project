<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Post;

use App\Entity\Post;
use App\Post\PostMapper;
use App\Post\PostsCollection;
use App\Exception\NullAttributeException;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;

/**
 * Service provides post data from the storage.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class PostService implements PostServiceInterface
{
    private $postRepository;
    private $userRepository;

    public function __construct(PostRepositoryInterface $postRepository, UserRepositoryInterface $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function deletePost(int $id): void
    {
        $post = $this->postRepository->find($id);
        $post->setIsPublished(false);
        $this->postRepository->save($post);
    }

    public function savePost(Post $post)
    {
        $this->postRepository->save($post);
    }

    public function findOne(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function getPost(string $slug)
    {
        return $this->postRepository->find($slug);
    }

    public function getPosts(string $slug)
    {
        $posts = $this->postRepository->findByUser($slug);
        $user = $this->userRepository->findOneBy(['username' => $slug]);

        $sharings = $user->getPostSharings();

        foreach($sharings as $sharing)
        {
            $post = $sharing->getPost();
            $postName = $post->getName();
            $posts[] = $post;
        }

        $collection = new PostsCollection();
        $dataMapper = new PostMapper();
        foreach ($posts as $post) {
            $collection->addPost($dataMapper->entityToDto($post));
        }
        return $collection;
    }

    public function update(int $id, array $data)
    {
        $post = $this->postRepository->find($id);

        if (null === $post) {
            return $post;
        }

        if (isset($data['name'])) {
            $post->setName($data['name']);
        }
        if (isset($data['content'])) {
            $post->setContent($data['content']);
        }
        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $post->setIsPublished($data['is_published']);
        }
        if (isset($data['user'])) {
            $user = $this->userRepository->findOneBy(['username' => $data['user']]);
            $post->setUser($user);
        }
        if (isset($data['author'])) {
            $post->setAuthor($data['author']);
        }

        $this->postRepository->save($post);

        return $post;
    }

    public function create(array $data)
    {
        if (isset($data['user']) && isset($data['name']) && isset($data['content'])) {
        } else {
            throw new NullAttributeException();
        }

        $user = $this->userRepository->findOneBy(['username' => $data['user']]);

        $post = new Post($user, $data['user']);
        $post->setName($data['name']);
        $post->setContent($data['content']);
        $post->setDateCreation(new \DateTime());

        $this->postRepository->save($post);

        return $post;
    }
}
