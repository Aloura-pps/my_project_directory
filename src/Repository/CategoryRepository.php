<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Category[] Returns an array of Category objects
    */
    public function findCategoriesWithArticles(): array
    {
        
    // REQUETE SQL à coder:
    // SELECT * FROM category c
    // WHERE c.id IN (SELECT DISTINCT(a.category_id) from articles a);

        $entityManager = $this->getEntityManager();
        

        $query = $entityManager->createQuery(
            "SELECT c FROM App\Entity\Category c
             WHERE c.id IN (SELECT DISTINCT(a.category) from App\Entity\Articles a)"
        );

        return $query->execute();

        // // On récupère le gestionnaire d'entités
        // $entityManager = $this->getDoctrine()->getManager();

        // // On crée une requête qui sélectionne toutes les catégories ayant au moins un article associé
        // $query = $entityManager->createQueryBuilder()
        //     ->select('c')
        //     ->from('App\Entity\Category', 'c')
        //     ->where('c.id IN (SELECT DISTINCT a.category FROM App\Entity\Article a)')
        //     ->getQuery();

        // // On exécute la requête
        // $categories = $query->getResult();
    }

    
//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
