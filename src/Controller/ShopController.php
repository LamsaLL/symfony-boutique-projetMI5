<?php
// Controller/shopController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ShopService;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
class ShopController extends AbstractController {
    public function index(CategoryRepository $categoryRepository) {
        $categories = $categoryRepository->findAll();
        return $this->render('shop.html.twig', [
            "categories" => $categories
        ]);
    }

    public function department($categoryId, ProductRepository $productRepository, CategoryRepository $categoryRepository) {
        // Get the category object with given id
        $category = $categoryRepository->find($categoryId);
        // Show all products with the given categoryId
        $products = $productRepository->findBy(["category" => $categoryId]);
        return $this->render('department.html.twig', [
           "category" => $category,
           "products" => $products
        ]);
    }
}