<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
