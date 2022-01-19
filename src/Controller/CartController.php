<?php
// Controller/CartControlle.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;

class CartController extends AbstractController {
    public function index(ProductRepository $productRepository) {
        $products = $productRepository->findAll();
        return $this->render('Cart/index.html.twig', [
            "categories" => $products
        ]);
    }
}