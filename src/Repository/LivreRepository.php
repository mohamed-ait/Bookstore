<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

     /**
      * @return Livre[] Returns an array of Livre objects
      */
    
    public function findByTitre($titre)
    {
        return $this->createQueryBuilder('livre')
            ->andWhere('livre.titre LIKE :titre')
            ->setParameter('titre', '%'.$titre.'%')
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
      * @return Livre[] Returns an array of Livre objects
      */
    
      public function getLivreBetweenTwoDates($dateMin,$dateMax)
      {
          return $this->createQueryBuilder('livre')
              ->andWhere('livre.titdate_parution  BETWEEN :dateMin AND :dateMax')
              ->setParameter('dateMin', $dateMin)
              ->setParameter('dateMax', $dateMax)
              ->getQuery()
              ->getResult()
          ;
      }
      
      /**
      * @return Livre[] Returns an array of Livre objects
      */
    
      public function getLivresByNote($note)
      {
          return $this->createQueryBuilder('livre')
              ->andWhere('livre.note  = :note')
              ->setParameter('note', $note)
              ->getQuery()
              ->getResult()
          ;
      }

       /**
      * @return Livre[] Returns an array of Livre objects
      */
    
      public function getLivresByGenre($genre)
      {
          return $this->createQueryBuilder('livre')
              ->innerJoin('livre.genres','g', 'WITH', 'g.id = :id')
              ->setParameter('id', $genre)
              ->getQuery()
              ->getResult()
          ;
      }

       /**
      * @return Livre[] Returns an array of Livre objects
      */
    
      public function getLivresByAutheur($genre)
      {
          return $this->createQueryBuilder('livre')
              ->innerJoin('livre.autheur','a', 'WITH', 'a.id = :id')
              ->setParameter('id', $autheur)
              ->getQuery()
              ->getResult()
          ;
      }
      
      /**
      * @return Livre[] Returns an array of Livre objects
      */
    
      public function getDates($genre)
      {
          return $this->createQueryBuilder('livre')
              ->select('livre.date_de_parution')
              ->distinct()
              ->getQuery()
              ->getResult()
          ;
      }
      
      

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
