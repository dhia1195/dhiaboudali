<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Domaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function countDomaine(Domaine $dom): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id)')
            ->where('u.domaine = :dom')
            ->setParameter('dom', $dom);
        $query = $qb->getQuery();
        return (int) $query->getSingleScalarResult();
    }

    public function countFreelancers(): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id)')
            ->where('u.role = 3');
        $query = $qb->getQuery();
        return (int) $query->getSingleScalarResult();
    }
    public function countBOwners(): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id)')
            ->where('u.role = 2');
        $query = $qb->getQuery();
        return (int) $query->getSingleScalarResult();
    }

    public function save(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByLogin(string $login): ?Utilisateur
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.login = :val')
            ->setParameter('val', $login)
            ->getQuery()
            ->getOneOrNullResult()
        ;
   }
   public function findOneByResetToken(string $token): ?Utilisateur
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.resettoken = :val')
            ->setParameter('val', $token)
            ->getQuery()
            ->getOneOrNullResult()
        ;
   }







//    /**
//     * @return Utilisateur[] Returns an array of Utilisateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Utilisateur
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
