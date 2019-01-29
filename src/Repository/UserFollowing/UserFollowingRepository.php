<?php

namespace App\Repository\UserFollowing;

use App\Entity\UserFollowing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserFollowing|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFollowing|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFollowing[]    findAll()
 * @method UserFollowing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFollowingRepository extends ServiceEntityRepository implements UserFollowingRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserFollowing::class);
    }

    public function findFollowings(int $id)
    {
        return $this->createQueryBuilder('f')
            ->select('identity(f.following)')
            ->andWhere('f.follower = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getResult()
            ;
    }

    public function findFollowers(int $id)
    {
        return $this->createQueryBuilder('f')
            ->select('identity(f.follower)')
            ->andWhere('f.following = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getResult()
            ;
    }

    public function save(UserFollowing $userFollowing): void
    {
        $em = $this->getEntityManager();
        $em->persist($userFollowing);
        $em->flush();
    }

    public function delete(int $followerId, int $followingId): void
    {
        $userFollowing = $this->createQueryBuilder('f')
            ->andWhere('f.follower = :followerId')
            ->andWhere('f.following = :followingId')
            ->setParameters([
                'followerId' => $followerId,
                'followingId' => $followingId,
            ])
            ->getQuery()
            ->getResult()
        ;

        $em = $this->getEntityManager();
        $em->remove($userFollowing[0]);
        $em->flush();
    }
}
