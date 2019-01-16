<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/8/19
 * Time: 7:57 PM
 */

namespace App\Dto;


final class Post
{
    private $id;
    private $name;
    private $content;
    private $isPublished;
    private $dateCreation;
    private $author;

    public function __construct(
        $id,
        string $name,
        string $content,
        bool $isPublished,
        \DateTimeInterface $dateCreation,
        string $author
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->isPublished = $isPublished;
        $this->dateCreation = $dateCreation;
        $this->author = $author;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function getDateCreation()
    {
        return $this->dateCreation->format('d-m-Y H:i:s');
    }

    public function getAuthor()
    {
        return $this->author;
    }
}