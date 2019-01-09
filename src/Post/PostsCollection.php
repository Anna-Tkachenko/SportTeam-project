<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 1/8/19
 * Time: 8:06 PM
 */

namespace App\Post;

use App\Dto\Post;

final class PostsCollection implements \IteratorAggregate
{
    private $posts;

    public function __construct(Post ...$posts)
    {
        $this->posts = $posts;
    }

    public function addPost(Post $post): void
    {
        $this->posts[] = $post;
    }

    public function shift(): ?Post
    {
        return \array_shift($this->posts);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->posts);
    }
}