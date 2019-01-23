<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 23.01.19
 * Time: 20:30
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
    )
    {
        $this->postRepository = $postRepository;
        $this->fileManager = $fileManager;
    }


    public function setData(Post $post, PostType $postType, $projectDir): Post
    {
        $post->setName($postType->getName());
        $post->setContent($postType->getContent());
        if($post->getDateCreation() === null) {
            $post->setDateCreation(new \DateTime());
        }

        if ( null != $postType->getImage()) {
            if( $post->getImage() != null) {
                $oldFilePath = $projectDir.'/public/uploads/'.$post->getImage();
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