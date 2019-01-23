<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

/**
 * Post DTO.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class Post
{
    private $id;
    private $name;
    private $content;
    private $isPublished;
    private $dateCreation;
    private $author;
    private $image;

    public function __construct(
        $id,
        string $name,
        string $content,
        bool $isPublished,
        \DateTimeInterface $dateCreation,
        string $author,
        $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->isPublished = $isPublished;
        $this->dateCreation = $dateCreation;
        $this->author = $author;
        $this->image = $image;
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

    public function getImage()
    {
        return $this->image;
    }
}
