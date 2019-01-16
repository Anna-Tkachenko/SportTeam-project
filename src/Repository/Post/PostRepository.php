<?php

namespace App\Repository\Post;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
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
                'name' => $slug
            ])
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function verifyPublished(string $username, $dateCreation)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->andWhere('u.username = :name')
            ->andWhere('p.dateCreation = :dateCreation')
            ->setParameters([
                'name' => $username,
                'dateCreation' => $dateCreation
            ])
            ->getQuery()
            ->getResult()
            ;
    }
}
