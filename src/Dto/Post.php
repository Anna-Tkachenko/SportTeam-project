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
    private $name;
    private $content;
    private $isPublished;
    private $dateCreation;

    public function __construct(
        string $name,
        string $content,
        bool $isPublished,
        $dateCreation
    )
    {
        $this->name = $name;
        $this->content = $content;
        $this->isPublished = $isPublished;
        $this->dateCreation = $dateCreation;
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
        return $this->dateCreation;
    }
}