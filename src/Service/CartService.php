<?php

// src/Service/PanierService.php
namespace App\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\ShopService;
// Service pour manipuler le panier et le stocker en session
class CartService {
 ////////////////////////////////////////////////////////////////////////////
 const Cart_SESSION = 'panier'; // Le nom de la variable de session du panier
 private $session; // Le service Session
 private $shop; // Le service Boutique
 private $cart; // Tableau associatif idProduit => quantite
 // donc $this->cart[$i] = quantiy du produit dont l'id = $id
 // constructeur du service
 public function __construct(SessionInterface $session, ShopService $shop) {
 // Récupération des services session et BoutiqueService
 $this->shop = $shop;
 $this->session = $session;
 // Récupération du panier en session s'il existe, init. à vide sinon
 $this->cart = $this->session->get(self::Cart_SESSION);// initialisation du Panier : à compléter,
 }
 // getContenu renvoie le contenu du panier
 // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
 public function getContent() {
    // Récupération du contenu du panier en session
    // Si le panier n'est pas vide
    if ($this->cart) {
        $products = [];
        // On crée un tableau d'éléments [ "product" => product, "quantity" => quantity ]
        foreach ($this->cart as $id => $quantity) {
            $products[] = [
                'product' => $this->shop->findProductById($id),
                'quantity' => $quantity,
            ];
        } 
      
        return $products;
    }
 } 

 // getTotal renvoie le montant total du panier
 public function getTotal() {
    // Récupération du contenu du panier en session
    // Si le panier n'est pas vide
    if ($this->cart) {
        $total = 0;
        // On crée un tableau d'éléments [ "product" => product, "quantity" => quantity ]
        foreach ($this->cart as $id => $quantity) {
            $product = $this->shop->findProductById($id);
            $total += $product["price"] * $quantity;
        }
        return $total;
    }
 }
  
 // getNbProduits renvoie le nombre de produits dans le panier
 public function getNbProducts() { 
    // Récupération du contenu du panier en session
    // Si le panier n'est pas vide
    if ($this->cart) {
        $nbProducts = 0;
        // On crée un tableau d'éléments [ "product" => product, "quantity" => quantity ]
        foreach ($this->cart as $id => $quantity) {
            $nbProducts += $quantity;
        }
        return $nbProducts;
    }
 }

 // AjouterProduit ajoute au panier le produit $idProduit en quantite $quantite
 public function addProduct(int $idProduct, int $quantity = 1) {
    // Si le panier n'est pas vide
    if ($this->cart) {
        // Si le produit est déjà dans le panier
        if (array_key_exists($idProduct, $this->cart)) {
            // On ajoute la quantité
            $this->cart[$idProduct] += $quantity;
        } else {
            // Sinon on ajoute le produit
            $this->cart[$idProduct] = $quantity;
        }
    } else {
        // Sinon on crée le panier
        $this->cart = [$idProduct => $quantity];
    }
    // On enregistre le panier en session
    $this->session->set(self::Cart_SESSION, $this->cart);
 } 

 // EnleverProduit enlève du panier le produit $idProduit en quantite $quantite
 public function removeProduct(int $idProduct, int $quantity = 1) {
    // Si le panier n'est pas vide
    if ($this->cart) {
        // Si le produit est dans le panier
        if (array_key_exists($idProduct, $this->cart)) {
            // On enlève la quantité
            $this->cart[$idProduct] -= $quantity;
            // Si la quantité est nulle ou négative
            if ($this->cart[$idProduct] <= 0) {
                // On supprime le produit
                unset($this->cart[$idProduct]);
            }
        }
    }
    // On enregistre le panier en session
    $this->session->set(self::Cart_SESSION, $this->cart);
 } 

 // SupprimerProduit supprime complètement le produit $idProduit du panier
 public function deleteProduct(int $idProduct) {
    // Si le panier n'est pas vide
    if ($this->cart) {
        // Si le produit est dans le panier
        if (array_key_exists($idProduct, $this->cart)) {
            // On supprime le produit
            unset($this->cart[$idProduct]);
        }
    }
    // On enregistre le panier en session
    $this->session->set(self::Cart_SESSION, $this->cart);
  }

 // Vider vide complètement le panier
 public function clear() { 
    // Si le panier n'est pas vide
    if ($this->cart) {
        // On vide le panier
        $this->cart = [];
    }
    // On enregistre le panier en session
    $this->session->set(self::Cart_SESSION, $this->cart);
 }
}