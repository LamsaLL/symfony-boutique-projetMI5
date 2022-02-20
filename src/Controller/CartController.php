<?php
// Controller/CartControlle.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CartController extends AbstractController
{
  public function index(CartService $cart)
  {
    $products = $cart->getContent();
    return $this->render('cart/index.html.twig', [
      'products' => $products,
      'total' => $cart->getTotal(),
      'nbProducts' => $cart->getNbProducts(),
    ]);
  }

  public function nbProducts(CartService $cart)
  {
    return $this->render('cart/nbProducts.html.twig', [
      'nbProducts' => $cart->getNbProducts(),
    ]);
  }

  public function add($productId, $quantity, CartService $cart)
  {
    // add new product to cart
    $cart->addProduct($productId, $quantity);
    // redirect to cart page and index route
    return $this->redirectToRoute('cart_index');
  }

  public function remove($productId, $quantity, CartService $cart)
  {
    // remove product to cart
    $cart->removeProduct($productId, $quantity);
    // redirect to cart page and index route
    return $this->redirectToRoute('cart_index');
  }

  public function delete($productId, CartService $cart)
  {
    // delete product to cart
    $cart->deleteProduct($productId);
    // redirect to cart page and index route
    return $this->redirectToRoute('cart_index');
  }

  public function clear(CartService $cart)
  {
    // delete product to cart
    $cart->clear();
    // redirect to cart page and index route
    return $this->redirectToRoute('cart_index');
  }

  public function validation(
    CartService $cart,
    EntityManagerInterface $entityManager
  ) {
    $user = $this->getUser();

    $order = $cart->cartToOrder($user);

    $entityManager->persist($order);
    $entityManager->flush();
    $cart->clear();
    // Display num and date of the order
    return $this->redirectToRoute('user_orders');
  }
}