<?php
// Controller/shopController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class shopController extends AbstractController {
    public function shop() {
        return $this->render('shop.html.twig');
    }


}