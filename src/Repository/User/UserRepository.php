<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\User;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|User find($id, $lockMode = null, $lockVersion = null)
 * @method null|User findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getResult();
    }

    public function loadUnActiveUser(\DateTimeInterface $dateTime)
    {
        return $this->createQueryBuilder('u')
            ->where('u.lastActiveAt < :datetime')
            ->andWhere('u.isActive = true')
            ->setParameter('datetime', $dateTime)
            ->getQuery()
            ->getResult();
    }

    public function loadById(array $id)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id in (:usersId)')
            ->setParameters([
                'usersId' => $id
            ])
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ;
    }

    public function loadAllUsers()
    {
        return $this->createQueryBuilder('u')
            ->getQuery();
    }

    public function save(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

    public function delete(int $id): void
    {
        $user = $this->find($id);
        $em = $this->getEntityManager();
        $em->remove($user);
        $em->flush();
    }
}
