<?php
// Controller/CartControlle.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use App\Service\CartService;

class CartController extends AbstractController {
    public function index(CartService $cart) {
        $products = $cart->getContent();
        return $this->render('cart/index.html.twig', [
            'products' => $products,
        ]);
    }

    //TODO: set $quantity to 1 if it is not set
    public function add($productId, $quantity, CartService $cart) {
        // add new product to cart
        $cart->addProduct($productId, $quantity);
        // redirect to cart page and index route
        return $this->redirectToRoute('cart_index');
    }

    //TODO: set $quantity to 1 if it is not set
    public function remove($productId, $quantity, CartService $cart) {
        // remove product to cart
        $cart->removeProduct($productId, $quantity);
        // redirect to cart page and index route
        return $this->redirectToRoute('cart_index');
    }

    public function validation(){

        // Display numero and date of the order
        return $this->render('Cart/validation.html.twig');
    }
}