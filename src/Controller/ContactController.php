<?php
// Controller/contactController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CartService;

class ContactController extends AbstractController
{
  public function index()
  {
    return $this->render('contact/index.html.twig');
  }
}