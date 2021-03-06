<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Post;

use App\Entity\Post;
use App\Exception\PostNotFoundException;
use App\Exception\NullAttributeException;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\PostSharing\PostSharingRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use Doctrine\ORM\Query;

/**
 * Service provides post data from the storage.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class PostService implements PostServiceInterface
{
    private $postRepository;
    private $userRepository;
    private $postSharingRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository,
        PostSharingRepositoryInterface $postSharingRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->postSharingRepository = $postSharingRepository;
    }

    public function deletePost(int $id): void
    {
        $post = $this->postRepository->find($id);
        $post->setIsPublished(false);
        $this->postRepository->save($post);
    }

    public function findOne(int $id)
    {
        $post = $this->postRepository->find($id);

        if (null === $post) {
            throw new PostNotFoundException('Post not found.');
        }

        return $post;
    }

    public function getPost(string $slug)
    {
        return $this->postRepository->find($slug);
    }

    public function getPosts(string $slug): Query
    {
        $user = $this->userRepository->findOneBy(['username' => $slug]);
        $postsId = $this->postSharingRepository->getPostIdByUser($user->getId());
        $postsQuery = $this->postRepository->findByUser($slug, $postsId);

        return $postsQuery;
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
