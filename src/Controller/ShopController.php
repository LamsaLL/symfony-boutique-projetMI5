<?php
// Controller/shopController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ShopService;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends AbstractController
{
  public function index(CategoryRepository $categoryRepository)
  {
    $categories = $categoryRepository->findAll();
    // Count number of categories
    $count = count($categories);

    return $this->render('shop/index.html.twig', [
      "categories" => $categories,
      'nbCategories' => $count,
    ]);
  }

  // Search products by name
  public function search($search = '', ProductRepository $productRepository)
  {
    // If search is empty, return all products
    if (empty($search)) {
      $products = $productRepository->findAll();
    } else {
      $products = $productRepository->findByName($search);
    }
    // Count the number of products found
    $count = count($products);

    return $this->render('shop/department.html.twig', [
      'products' => $products,
      'search' => $search,
      'nbProducts' => $count,
    ]);
  }

  public function department(
    $categoryId,
    ProductRepository $productRepository,
    CategoryRepository $categoryRepository
  ) {
    // Get the category object with given id
    $category = $categoryRepository->find($categoryId);
    // Show all products with the given categoryId
    $products = $productRepository->findBy(["category" => $categoryId]);
    // Count the number of products found
    $count = count($products);

    return $this->render('shop/department.html.twig', [
      "category" => $category,
      "products" => $products,
      "nbProducts" => $count,
    ]);
  }
}