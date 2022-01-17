<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;

// Un service pour manipuler le contenu de la Boutique
//  qui est composée de catégories et de produits stockés "en dur"
class ShopService {

    // renvoie toutes les catégories
    public function findAllCategories() {
        return $this->categories;
    }

    // renvoie la categorie dont id == $categoryId
    public function findCategoryById(int $categoryId) {
        $res = array_filter($this->categories,
                function ($c) use($categoryId) {
            return $c["id"] == $categoryId;
        });
        return (sizeof($res) === 1) ? $res[array_key_first($res)] : null;
    }

    // renvoie le produit dont id == $productId
    public function findProductById(int $productId) {
        $res = array_filter($this->products,
                function ($p) use($productId) {
            return $p["id"] == $productId;
        });
        return (sizeof($res) === 1) ? $res[array_key_first($res)] : null;
    }

    // renvoie tous les produits dont categoryId == $categoryId
    public function findProductsByCategory(int $categoryId) {
        return array_filter($this->products,
                function ($p) use($categoryId) {
            return $p["categoryId"] == $categoryId;
        });
    }

    // renvoie tous les produits dont libelle ou texte contient $search
    public function findProductsByLabelOrText(string $search) {
        return array_filter($this->products,
                function ($p) use ($search) {
                  return ($search=="" || mb_strpos(mb_strtolower($p["label"]." ".$p["text"]), mb_strtolower($search)) !== false);
        });
    }

    // constructeur du service : injection des dépendances et tris
    public function __construct(RequestStack $requestStack) {
        // Injection du service RequestStack
        //  afin de pouvoir récupérer la "locale" dans la requête en cours
        $this->requestStack = $requestStack;
        // On trie le tableau des catégories selon la locale
        usort($this->categories, function ($c1, $c2) {
            return $this->compareSelonLocale($c1["label"], $c2["label"]);
        });
        // On trie le tableau des produits de chaque catégorie selon la locale
        usort($this->products, function ($c1, $c2) {
            return $this->compareSelonLocale($c1["label"], $c2["label"]);
        });
    }

    ////////////////////////////////////////////////////////////////////////////

    private function compareSelonLocale(string $s1, $s2) {
        $collator=new \Collator($this->requestStack->getCurrentRequest()->getLocale());
        return collator_compare($collator, $s1, $s2);
    }

    private $requestStack; // Le service RequestStack qui sera injecté
    // Le catalogue de la boutique, codé en dur dans un tableau associatif
    private $categories = [
        [
            "id" => 1,
            "label" => "Fruits",
            "image" => "images/fruits.jpg",
            "text" => "De la passion ou de ton imagination",
        ],
        [
            "id" => 3,
            "label" => "Junk Food",
            "image" => "images/junk_food.jpg",
            "text" => "Chère et cancérogène, tu es prévenu(e)",
        ],
        [
            "id" => 2,
            "label" => "Légumes",
            "image" => "images/legumes.jpg",
            "text" => "Plus tu en manges, moins tu en es un"],
    ];
    private $products = [
        [
            "id" => 1,
            "categoryId" => 1,
            "label" => "Pomme",
            "text" => "Elle est bonne pour la tienne",
            "image" => "images/pommes.jpg",
            "price" => 3.42
        ],
        [
            "id" => 2,
            "categoryId" => 1,
            "label" => "Poire",
            "text" => "Ici tu n'en es pas une",
            "image" => "images/poires.jpg",
            "price" => 2.11
        ],
        [
            "id" => 3,
            "categoryId" => 1,
            "label" => "Pêche",
            "text" => "Elle va te la donner",
            "image" => "images/peche.jpg",
            "price" => 2.84
        ],
        [
            "id" => 4,
            "categoryId" => 2,
            "label" => "Carotte",
            "text" => "C'est bon pour ta vue",
            "image" => "images/carottes.jpg",
            "price" => 2.90
        ],
        [
            "id" => 5,
            "categoryId" => 2,
            "label" => "Tomate",
            "text" => "Fruit ou Légume ? Légume",
            "image" => "images/tomates.jpg",
            "price" => 1.70
        ],
        [
            "id" => 6,
            "categoryId" => 2,
            "label" => "Chou Romanesco",
            "text" => "Mange des fractales",
            "image" => "images/romanesco.jpg",
            "price" => 1.81
        ],
        [
            "id" => 7,
            "categoryId" => 3,
            "label" => "Nutella",
            "text" => "C'est bon, sauf pour ta santé",
            "image" => "images/nutella.jpg",
            "price" => 4.50
        ],
        [
            "id" => 8,
            "categoryId" => 3,
            "label" => "Pizza",
            "text" => "Y'a pas pire que za",
            "image" => "images/pizza.jpg",
            "price" => 8.25
        ],
        [
            "id" => 9,
            "categoryId" => 3,
            "label" => "Oreo",
            "text" => "Seulement si tu es un smartphone",
            "image" => "images/oreo.jpg",
            "price" => 2.50
        ],
    ];
}