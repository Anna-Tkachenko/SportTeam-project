<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 23.01.19
 * Time: 20:50
 */

namespace App\Dto;


class PostType
{
    private $name;
    private $content;
    private $image;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}