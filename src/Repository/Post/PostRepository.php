<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\Post;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Post find($id, $lockMode = null, $lockVersion = null)
 * @method null|Post findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findByUser(string $slug)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->andWhere('u.username = :name')
            ->andWhere('p.isPublished = true')
            ->setParameters([
                'name' => $slug,
            ])
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function deletePost(int $id): void
    {
        $post = $this->find($id);
        $em = $this->getEntityManager();
        $em->remove($post);
        $em->flush();
    }

    public function save(Post $post): void
    {
        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();
    }
}
