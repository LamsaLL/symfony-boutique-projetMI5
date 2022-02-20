<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Product::class);
  }

  public function createPoduct()
  {
    $product = new Product();
    $product->setName('Un nouveau produit');
    $product->setPrice(19.99);
    $em = $this->getDoctrine()->getManager();
    $em->persist($product);
    $em->flush();
    return new Response('Produit créé avec id ' . $product->getId());
  }

  public function updateProduct($id)
  {
    $em = $this->ZgetDoctrine()->getManager();
    $product = $em->getRepository(Product::class)->find($id);
    if (!$product) {
      // throw $this->createNotFoundException('No product found for id '.$id);
    }
    $product->setName('New product name!');
    $em->flush();
  }

  public function showProduct($id)
  {
    $product = $this->getDoctrine()
      ->getManager()
      ->getRepository(Product::class)
      ->find($id);
    // if (!$product) {
    // throw $this->createNotFoundException('Produit non trouvé avec id '.$id);
    // }
  }

  // Toutes les requêtes sont à mettre dans le repository /**
  /**
   * @return Product[]
   */
  public function findAllGreaterThanPrice($price): array
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager
      ->createQuery(
        'SELECT p
        FROM App\Entity\Product p
        WHERE p.price > :price
        ORDER BY p.price ASC'
      )
      ->setParameter('price', $price);
    // returns an array of Product objects
    return $query->getResult();
  }

  // Find products on search string on name
  public function findByName($search)
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager
      ->createQuery(
        'SELECT p
        FROM App\Entity\Product p
        WHERE p.name LIKE :search
        ORDER BY p.name ASC'
      )
      ->setParameter('search', '%' . $search . '%');
    // returns an array of Product objects
    return $query->getResult();
  }

  // /**
  //  * @return Product[] Returns an array of Product objects
  //  */
  /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

  /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}