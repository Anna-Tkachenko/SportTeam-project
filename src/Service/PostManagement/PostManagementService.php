<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\PostManagement;

use App\Dto\PostType;
use App\Entity\Post;
use App\Repository\Post\PostRepositoryInterface;
use App\Service\FileSystem\FileManagerInterface;

class PostManagementService implements PostManagementServiceInterface
{
    private $postRepository;
    private $fileManager;

    public function __construct(
        PostRepositoryInterface $postRepository,
        FileManagerInterface $fileManager
    ) {
        $this->postRepository = $postRepository;
        $this->fileManager = $fileManager;
    }


    public function setData(Post $post, PostType $postType, $projectDir): Post
    {
        $post->setName($postType->getName());
        $post->setContent($postType->getContent());

        if (null === $post->getDateCreation()) {
            $post->setDateCreation(new \DateTime());
        }

        if (null != $postType->getImage()) {
            if (null != $post->getImage()) {
                $oldFilePath = $projectDir . '/public/uploads/' . $post->getImage();
                unlink($oldFilePath);
            }
            $fileName = $this->fileManager->upload($postType->getImage());
            $post->setImage($fileName);
        }

        $this->save($post);

        return $post;
    }

    public function getData(Post $post): PostType
    {
        $postType = new PostType();
        $postType->setName($post->getName());
        $postType->setContent($post->getContent());

        return $postType;
    }

    public function save(Post $post): void
    {
        $this->postRepository->save($post);
    }
}
