<?php

namespace App\Repository;

use App\Entity\Nationalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nationalite>
 *
 * @method Nationalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nationalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nationalite[]    findAll()
 * @method Nationalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NationaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nationalite::class);
    }

    public function natioStats(): array
    {
        return $this->createQueryBuilder('n')
            ->select('n as obj_natio', 'count(a) as nbArtistes')
            ->join('n.artistes', 'a')
            ->groupBy('n.id')
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function choiceList(): array
    {
        $result = $this->createQueryBuilder('n')
            ->select('n.libelle as libelle', 'n.id as id')
            ->orderBy('n.libelle', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $output = [];
        foreach ($result as $r) {
            $output[$r['libelle']] = $r['id'];
        }

        return $output;
    }

//    /**
//     * @return Nationalite[] Returns an array of Nationalite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nationalite
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
