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
        return $this->render('shop.html.twig', [
            "categories" => $categories
        ]);
    }

    // Search products by name
    public function search($search, ProductRepository $productRepository)
    {
        $products = $productRepository->findByName($search);

        // Count the number of products found
        $count = count($products);

        return $this->render('department.html.twig', [
            'products' => $products,
            'search' => $search,
            'nbProducts' => $count
        ]);
    }

    public function department($categoryId, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        // Get the category object with given id
        $category = $categoryRepository->find($categoryId);
        // Show all products with the given categoryId
        $products = $productRepository->findBy(["category" => $categoryId]);
        // Count the number of products found
        $count = count($products);
        return $this->render('department.html.twig', [
            "category" => $category,
            "products" => $products,
            "nbProducts" => $count
        ]);
    }
}