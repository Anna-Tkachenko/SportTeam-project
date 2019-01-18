<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 18.01.19
 * Time: 22:38
 */

namespace App\Service\Post;


use App\Api\ApiMapperInterface;
use App\Entity\Post;
use App\Entity\User;
use App\Exception\NullAttributeException;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;

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
        $this->postRepository->deletePost($id);
    }

    public function sharePost(Post $sharedPost, User $user)
    {
        $post = new Post();
        $post->setName($sharedPost->getName());
        $post->setContent($sharedPost->getContent());
        $post->setIsPublished(true);
        $post->setUser($user);
        $post->setAuthor($sharedPost->getAuthor());
        $post->setDateCreation($sharedPost->getDateCreation());

        $this->postRepository->save($post);
    }

    public function savePost(Post $post)
    {
        $this->postRepository->save($post);
    }

    public function create(array $data)
    {
        $faker = \Faker\Factory::create();
        if(isset($data['user']) && isset($data['name']) && isset($data['content']) ){} else{
            throw new NullAttributeException();
        }

        $user = $this->userRepository->findOneBy(['username' => $data['user']]);

        $post = new Post();
        $post->setName($data['name']);
        $post->setContent($data['content']);
        $post->setIsPublished(true);
        $post->setUser($user);
        $post->setAuthor($data['user']);
        $post->setDateCreation($faker->dateTime);

        $this->postRepository->save($post);

        return $post;
    }

    public function findOne(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        $post = $this->postRepository->find($id);

        if(is_null($post)){
            return $post;
        }

        if(isset($data['name'])){
            $post->setName($data['name']);
        }
        if(isset($data['content'])){
            $post->setContent($data['content']);
        }
        if(isset($data['is_published']) && is_bool($data['is_published'])){
            $post->setIsPublished($data['is_published']);
        }
        if(isset($data['user'])){
            $user = $this->userRepository->findOneBy(['username' => $data['user']]);
            $post->setUser($user);
        }
        if(isset($data['author'])){
            $post->setAuthor($data['author']);
        }

        $this->postRepository->save($post);

        return $post;
    }
}