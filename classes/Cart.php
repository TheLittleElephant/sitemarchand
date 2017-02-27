<?php
/**
 * Classe permettant la gestion du panier
 * @version 1.0
 * @since 06/05/2016
 * @author Jonathan
 */
class Cart {
    
    /**
     * Contient l'objet Database
     * @var Database
     */
    private $db;
    
    /**
     * Contient l'objet Messages
     * @var Messages
     */
    private $messages;
   
    /**
     * Construit l'objet Cart, initialise les propriétés puis vérifie la session n'est pas démarrée et construit le panier s'il n'existe pas
     * @param Database $db Permet d'accéder aux méthodes de la classe Database
     * @param Messages $messages Permet d'accéder aux méthodes de la classe Messages
     */
    function __construct(Database $db, Messages $messages) {
        
        if (!session_id()) {
            session_start();
        } 
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        
        $this->db = $db;
        $this->messages = $messages;
        
    }
    
   
     /**
     * Ajoute le produit dans le panier
     * @param string $post_submit Bouton de validation du formulaire
     * @param string $post_id Identifiant du produit dans la base de données
     * @param string $post_name Nom du produit
     * @param string $post_quantity Quantité du produit
     * @param string $post_price Prix du produit
     * @return boolean
     */
    function addToCart($post_submit, $post_id, $post_name, $post_quantity, $post_price) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_name]) && isset($_POST[$post_quantity]) && isset($_POST[$post_price])
                && !empty($_POST[$post_name]) && !empty($_POST[$post_quantity]) && !empty($_POST[$post_price])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $name = htmlspecialchars($_POST[$post_name]);
            $quantity = (int) htmlspecialchars($_POST[$post_quantity]);
            $price = (float) htmlspecialchars($_POST[$post_price]);
            $image = $this->db->getDb()->query("SELECT image FROM produits WHERE id = '$id'")->fetchObject()->image;
            $stock = $this->db->getDb()->query("SELECT stock FROM produits WHERE id = '$id'")->fetchObject()->stock;
            if($stock != 0) {
                if ($quantity > $stock) {
                    $_SESSION["cart"][$name] = array("id" => $id, "image" => $image, "name" => $name, "price" => $price, "quantity" => $stock, "subtotal" => (float) ($price * $stock), "stock" => $stock);
                    $this->messages->add("info", "Le produit a bien été ajouté mais nous avons mis à jour la quantité de <b>$name</b> à <b>$stock</b>");
                    header("Location: ../cart");
                } else {
                    $_SESSION["cart"][$name] = array("id" => $id, "image" => $image, "name" => $name, "price" => $price, "quantity" => $quantity, "subtotal" => (float) ($price * $quantity), "stock" => $stock);
                    $this->messages->add("success", PRODUCT_ADDED);
                    header("Location: ../cart");
                }
                return true;
            }
        }
        return false;
    }
    
    /**
     * Met à jour le panier
     * @param string $post_submit Bouton de validation du formulaire
     * @param string $post_id Identifiant du produit dans la base de données
     * @param string $post_index Index du produit dans le tableau
     * @param string $post_quantity Quantité du produit
     * @return boolean
     */
    function updateCart($post_submit, $post_index, $post_quantity) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_index]) && isset($_POST[$post_quantity])
              && !empty($_POST[$post_index]) && !empty($_POST[$post_quantity])) {
            $index = htmlspecialchars($_POST[$post_index]);
            $quantity = (int) htmlspecialchars($_POST[$post_quantity]);
            $price = (float) $_SESSION["cart"][$index]["price"];
            $stock = (int) $_SESSION["cart"][$index]["stock"];
            if($quantity > $stock) {
                 $_SESSION["cart"][$index]["quantity"] = $stock;
                 $_SESSION["cart"][$index]["subtotal"] = (float)($price*$stock);
                 $this->messages->add("info", "Le produit a bien été modifié mais nous avons mis à jour la quantité de votre produit à <b>$stock</b>");
                 header("Location: ../cart");
            } else {
                 $_SESSION["cart"][$index]["quantity"] = $quantity;
                 $_SESSION["cart"][$index]["subtotal"] = (float)($price*$quantity);
                 $this->messages->add("success", PRODUCT_MODIFIED);
                 header("Location: ../cart");
            }
            return true;
        }
        return false;
    }
    
    /**
     * Supprime un produit du panier en utilisant sa référence
     * @param string $post_submit Bouton de validation du formulaire
     * @param string $post_index Index du produit dans le tableau
     * @return boolean
     */
    function deleteFromCart($post_submit, $post_index) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_index])
                && !empty($_POST[$post_index])) {
            $index = htmlspecialchars($_POST[$post_index]);
            unset($_SESSION["cart"][$index]);
            return true;
        }
        return false;
    }
    
    /**
     * Retourne le panier
     * @return array
     */
    function getCart() {
        return $_SESSION["cart"];
    }
    
    /**
     * Retourne le nombre de produits contenus dans le panier
     * @return int
     */
    function productsNumber() {
        $number = 0;
        foreach($_SESSION["cart"] as $index => $product) {
            $number += $_SESSION["cart"][$index]["quantity"];
        }
        return $number;
    }
    
    /**
     * Retourne le prix total des achats
     * @return float
     */
    function totalPrice() {
        $price = 0;
        foreach($_SESSION["cart"] as $index => $product) {
            $price += $_SESSION["cart"][$index]["subtotal"];
        }
        return (float) $price;
    }
    
    /**
     * Valide le panier
     */
    function cartCheckout() {
        $totalPrice = $this->totalPrice();
        $totalQuantity = $this->productsNumber();
        $userId = Authentication::getUserId();
        $this->db->getDb()->query("INSERT INTO commandes(idClient, date, prixTotal, quantiteTotale) VALUES($userId, NOW(), $totalPrice, $totalQuantity)");
        $orderId = $this->db->getDb()->lastInsertId();
        foreach($_SESSION["cart"] as $cartProduct) {
            $productId = $cartProduct["id"];
            $quantity = $cartProduct["quantity"];
            $price = $cartProduct["price"];
            $stock = $cartProduct["stock"];
            $subTotal = (float) ($price*$quantity);
            $this->db->getDb()->query("INSERT INTO lignecommande(idCommande, idProduit, quantite, prixUnitaire, sousTotal) VALUES('$orderId', '$productId', '$quantity', '$price', '$subTotal') ");
            $stock -= $quantity;
            $this->db->getDb()->query("UPDATE produits SET stock = '$stock' WHERE id = '$productId'");
        }
        $this->emptyCart();
    }
    
    /**
     * Vide le panier
     */
    function emptyCart() {
        if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
    }


}
