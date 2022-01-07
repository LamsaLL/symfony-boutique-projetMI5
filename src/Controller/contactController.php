<?php
// Controller/contactController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class contactController extends AbstractController {
    public function contact() {
        return $this->render('contact.html.twig');
    }

}