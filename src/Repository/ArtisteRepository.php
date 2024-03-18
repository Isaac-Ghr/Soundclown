<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artiste>
 *
 * @method Artiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiste[]    findAll()
 * @method Artiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

    /**
    * @return Artiste[] Returns an array of Artiste objects
    */
    public function listeArtistesComplete()
    {
        return $this->createQueryBuilder('a')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Query Returns an array of Artiste objects
    */
    public function listeArtistesCompleteP(): Query
    {
        return $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery()
        ;
    }
    
    /**
    * @return Query Returns an array of Artiste objects
    */
    public function listeArtistesFiltreP(?string $nom, ?int $natioID): Query
    {
        $query = $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->join('art.nationalite', 'n')
            ->leftJoin('art.albums', 'a')
        ;

        if ($nom) {
            $query->andWhere('art.nom like :nomp')
                ->setParameter('nomp', "%{$nom}%");
        }

        if ($natioID) {
            $query->andWhere('n.id = :nid')
                ->setParameter('nid', $natioID);
        }

        $query->orderBy('art.nom', 'ASC');

        return $query->getQuery();
    }

//    /**
//     * @return Artiste[] Returns an array of Artiste objects
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

//    public function findOneBySomeField($value): ?Artiste
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
