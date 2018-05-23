<?php

namespace App\Repository;

use App\Entity\IssueComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IssueComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method IssueComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method IssueComment[]    findAll()
 * @method IssueComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IssueCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IssueComment::class);
    }

    /**
     * @return IssueComment[] Returns an array of IssueComment objects
     */

    public function findByIssueId($issueId)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.issueId = :val')
            ->setParameter('val', $issueId)
            ->orderBy('i.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?IssueComment
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
