<?php

namespace App\Repository;

use App\Entity\UrlShort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UrlShort|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlShort|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlShort[]    findAll()
 * @method UrlShort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method integer       clicksUp(string $short);
 */
class UrlShortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlShort::class);
    }

    /**
     * Increase clicks counter.
     *
     */
    public function clicksUp(string $short) : int
    {
        return $this->createQueryBuilder('u')
            ->update($this->getEntityName(), 'u')
            ->set('u.clicks_count', 'u.clicks_count+1')
            ->where('u.short = :short')->setParameter('short', $short)
            ->getQuery()
            ->execute();
    }

    public function findAllPaginated($page = 0)
    {
        return $this->createQueryBuilder('u')
            ->setFirstResult($page*UrlShort::PAGE_SIZE)
            ->setMaxResults(UrlShort::PAGE_SIZE)
            ->getQuery()
            ->getResult();
    }
}
