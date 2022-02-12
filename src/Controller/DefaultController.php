<?php
// Controller/DefaultController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CartService;
class DefaultController extends AbstractController {
    public function index(CartService $cart) {
        return $this->render('home.html.twig');
    }
}