<?php
// Controller/shopController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ShopService;

class ShopController extends AbstractController {
    public function index(ShopService $shop) {
        $categories = $shop->findAllCategories();
        return $this->render('shop.html.twig', [
            "categories" => $categories
        ]);
    }
}