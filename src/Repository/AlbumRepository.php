<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
    * @return Query Returns an array of Album objects
    */
    public function listeAlbumsComplete(): Query
    {
        return $this->createQueryBuilder('a')
            ->select('a', 's', 'art', 'l')
            ->innerJoin('a.styles', 's')
            ->innerJoin('a.artiste', 'art')
            ->innerJoin('a.label', 'l')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
        ;
    }
    
    /**
    * @return Query Returns an array of Album objects
    */
    public function listeAlbumsFiltre(?string $nom, ?int $style): Query
    {
        $query = $this->createQueryBuilder('a')
            ->select('a', 's', 'art', 'l')
            ->innerJoin('a.styles', 's')
            ->innerJoin('a.artiste', 'art')
            ->innerJoin('a.label', 'l')
        ;

        if ($nom) {
            $query->andWhere("a.nom like :nom")->setParameter(":nom", "%{$nom}%");
        }

        if ($style) {
            $condition = $query->expr()->isMemberOf(":style", "a.styles");
            $query->setParameter(":style", "{$style}");
            $query->andWhere($condition);
        }

        // $query->orderBy('a.nom', 'ASC');

        return $query->getQuery();
    }

//    /**
//     * @return Album[] Returns an array of Album objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Album
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
