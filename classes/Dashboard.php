<?php
/**
 * Classe permettant permettant le fonctionnement de l'interface d'administration
 * @version 1.0
 * @since 07/05/2016
 * @author Jonathan
 */
class Dashboard {
    
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
     *  Constante définissant le nombre de produits pouvant être affichés sur l'interface d'administration
     */
    const NUMBER_OF_PRODUCTS_SHOWED = 5;
    
    /**
     * Construit l'objet Dashboard et initialise les propriétés
     * @param Database $db Permet d'accéder aux méthodes de la classe Database
     * @param Messages $messages Permet d'accéder aux méthodes de la classe Messages
     */
    function __construct(Database $db, Messages $messages) {
        $this->db = $db;
        $this->messages = $messages;
    }

     /**
     * Ajoute un produit dans la base de données
     * @param string $post_submit Bouton de validation 
     * @param string $post_image Nom du fichier image du produit
     * @param string $post_name Nom du produit
     * @param string $post_category Famille du produit
     * @param string $post_description Description du produit
     * @param string $post_price Prix du produit
     * @param string $post_stock Stock du produit
     * @return boolean
     */
    function addProduct($post_submit, $post_image, $post_name, $post_category, $post_description, $post_price, $post_stock) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_image]) && isset($_POST[$post_name]) && isset($_POST[$post_category]) && isset($_POST[$post_description]) && isset($_POST[$post_price]) && isset($_POST[$post_stock]) && !empty($_POST[$post_image]) && !empty($_POST[$post_name]) && !empty($_POST[$post_category]) &&!empty($_POST[$post_description]) 
                && !empty($_POST[$post_price]) && !empty($_POST[$post_stock])) {
            $image = htmlspecialchars($_POST[$post_image]);
            $name = htmlspecialchars($_POST[$post_name]);
            $category = htmlspecialchars($_POST[$post_category]);
            $description = htmlspecialchars($_POST[$post_description]);
            $price = htmlspecialchars($_POST[$post_price]);
            $stock = htmlspecialchars($_POST[$post_stock]);
            $this->db->getDb()->query("INSERT INTO produits(idFamille, nom, description, image, prix, stock) VALUES('$category', '$name', '$description', '$image', '$price', '$stock')");
            return true;
        }
        return false;
    }
    
    /**
     * Met à jour un produit dans la base de données
     * @param string $post_submit Bouton de validation
     * @param string $post_id ID du produit
     * @param string $post_image Nom du fichier image du produit
     * @param string $post_name Nom du produit
     * @param string $post_category Famille du produit
     * @param string $post_description Description du produit
     * @param string $post_price Prix du produit
     * @param string $post_stock Quantité en stock du produit
     * @return boolean
     */
    function updateProduct($post_submit, $post_id, $post_image, $post_name, $post_category, $post_description, $post_price, $post_stock) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_id]) && isset($_POST[$post_image]) 
                && isset($_POST[$post_name]) && isset($_POST[$post_category]) && isset($_POST[$post_description]) && isset($_POST[$post_price]) && isset($_POST[$post_stock])
                && !empty($_POST[$post_id]) && !empty($_POST[$post_image]) && !empty($_POST[$post_name]) && !empty($_POST[$post_category]) &&!empty($_POST[$post_description]) 
                && !empty($_POST[$post_price]) && !empty($_POST[$post_stock])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $image = htmlspecialchars($_POST[$post_image]);
            $name = htmlspecialchars($_POST[$post_name]);
            $category = htmlspecialchars($_POST[$post_category]);
            $description = htmlspecialchars($_POST[$post_description]);
            $price = htmlspecialchars($_POST[$post_price]);
            $stock = htmlspecialchars($_POST[$post_stock]);
            $this->db->getDb()->query("UPDATE produits SET idFamille = '$category',  nom = '$name', description = '$description', image = '$image', prix = '$price', stock = '$stock' WHERE id = '$id'");
            return true;
        }
        return false;
    }
    
    /**
     * Supprime un produit
     * @param string $post_submit
     * @param string $post_id
     * @return boolean
     */
    function deleteProduct($post_submit, $post_id) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_id]) && !empty($_POST[$post_id])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $this->db->getDb()->query("DELETE FROM produits WHERE id = '$id'");
            return true;
        }
        return false;
    }
    
    /**
     * Ajoute une famille dans la base de données
     * @param string $post_submit Bouton de validation
     * @param string $post_name Nom de la famille
     * @return boolean
     */
    function addCategory($post_submit, $post_name) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_name]) && !empty($_POST[$post_name])) {
            $name = htmlspecialchars($_POST[$post_name]);
            $this->db->getDb()->query("INSERT INTO familles(nom) VALUES('$name')");
            return true;
        }
        return false;
    }
    
    /**
     * Met à jour une famille
     * @param string $post_submit Bouton de validation 
     * @param string $post_id ID de la famille
     * @param string $post_name Nom de la famille
     * @return boolean
     */
    function updateCategory($post_submit, $post_id, $post_name, Database $db) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_id]) 
                && isset($_POST[$post_name]) && !empty($_POST[$post_id]) && !empty($_POST[$post_name])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $name = htmlspecialchars($_POST[$post_name]);
            $this->db->getDb()->query("UPDATE familles SET nom = '$name' WHERE id = '$id'");
            return true;
        }
        return false;
    }
    
    /**
     * Supprime une famille
     * @param string $post_submit
     * @param string $post_id
     * @return boolean
     */
    function deleteCategory($post_submit, $post_id, Database $db) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_id]) && !empty($_POST[$post_id])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $this->db->getDb()->query("DELETE FROM familles WHERE id = '$id'");
            return true;
        }
        return false;
    }
    
    /**
     * Ajoute un utilisateur dans la base de données
     * @param string $post_submit
     * @param string $post_lname
     * @param string $post_fname
     * @param string $post_username
     * @param string $post_password
     * @param string $post_role
     * @return boolean
     */
    function addUser($post_submit, $post_lname, $post_fname, $post_username, $post_password, $post_role) {
         if(isset($_POST[$post_submit]) && isset($_POST[$post_lname]) && isset($_POST[$post_fname]) 
             && isset($_POST[$post_username]) && isset($_POST[$post_password]) && isset($_POST[$post_role])
             && !empty($_POST[$post_lname]) && !empty($_POST[$post_fname]) && !empty($_POST[$post_username]) &&!empty($_POST[$post_password]) 
             && !empty($_POST[$post_role])) {
            $lname = htmlspecialchars($_POST[$post_lname]);
            $fname = htmlspecialchars($_POST[$post_fname]);
            $username = htmlspecialchars($_POST[$post_username]);
            $password = md5(htmlspecialchars($_POST[$post_password]));
            $role = htmlspecialchars($_POST[$post_role]);
            $this->db->getDb()->query("INSERT INTO clients(login, mdp, nom, prenom, role) VALUES('$username', '$password', '$lname', '$fname', '$role'");
            return true;
        }
        return false;
    }
    
    /**
     * Met à jour les informations de l'utilisateur 
     * @param string $post_submit
     * @param string $post_id
     * @param string $post_lname
     * @param string $post_fname
     * @param string $post_username
     * @param string $post_password
     * @param string $post_role
     * @return boolean
     */
    function updateUser($post_submit, $post_id, $post_lname, $post_fname, $post_username, $post_password, $post_role) {
         if(isset($_POST[$post_submit]) && isset($_POST[$post_id]) && isset($_POST[$post_lname]) 
                && isset($_POST[$post_fname]) && isset($_POST[$post_username]) && isset($_POST[$post_password]) && isset($_POST[$post_role])
                && !empty($_POST[$post_id]) && !empty($_POST[$post_lname]) && !empty($_POST[$post_fname]) && !empty($_POST[$post_username]) &&!empty($_POST[$post_password]) 
                && !empty($_POST[$post_role])) {
            $id = htmlspecialchars($_POST[$post_id]);
            $lname = htmlspecialchars($_POST[$post_lname]);
            $fname = htmlspecialchars($_POST[$post_fname]);
            $username = htmlspecialchars($_POST[$post_username]);
            $password = htmlspecialchars($_POST[$post_password]);
            $role = htmlspecialchars($_POST[$post_role]);
            $this->db->getDb()->query("UPDATE clients SET nom = '$lname', prenom = '$fname', login = '$username', mdp = '$password', role = '$role' WHERE id = '$id'");
            return true;
        }
        return false;
    }
    
    /**
     * Liste les images du dossier /img après avoir enlevé le "." et le ".." du tableau
     * @param string $folder
     * @return array
     */
    function getImagesFilenames($folder = "../img") {
       $filenames = array_slice(scandir($folder),2);
       for($i = 0; $i < count($filenames); $i++) {
           $filenames[$i] = substr($filenames[$i], -strlen($filenames[$i]), -4);
       }
       return $filenames;
    }
    
    /**
     * Permet de limiter les résultats de la requête de sélection des produits de la base de données
     * @param string $get_page Nom du paramètre $_GET
     * @return int
     */
    function paginator($get_page) {
        $pagesNumber = ceil($this->db->productsCount()/self::NUMBER_OF_PRODUCTS_SHOWED);
        if(isset($_GET[$get_page])) {
            $currentPage = intval($_GET[$get_page]);
            if($currentPage > $pagesNumber) {
                $currentPage = $pagesNumber;
            }
        }
        else {
           $currentPage = 1;
        }   
        return ($currentPage-1)*self::NUMBER_OF_PRODUCTS_SHOWED;
    }
    
    /**
     * Retourne le nombre de pages 
     * @return int
     */
    function getPaginatorPagesNumber() {
        return ceil($this->db->productsCount()/self::NUMBER_OF_PRODUCTS_SHOWED);
    }
    
    /**
     * Vérifie si des produits sont épuisés et prévient l'administrateur si c'est le cas
     * @param Messages $messages Permet d'ajouter des messages et d'accéder aux méthodes de la classe Messages
     */
    function checkProductsWithEmptyStock(){
        $products = $this->db->getAllProducts();
        $message = "Les produits suivants sont épuisés : <br><ul>";
        $emptyStockCount = 0;
        foreach($products as $product) {
            if($product["stock"] == 0) {
                $message .= "<li><b>".$product["nom"]."</b></li>";
                $emptyStockCount++;
            }
        }
        $message .= "</ul>";
        if($emptyStockCount > 0) {
             $this->messages->add("warning", $message);
        }
    }
    
    /**
     * Recherche dans la base de données un ou plusieurs produit en fonction des mots-clés entrés par l'utilisateur
     * @param string $keywords Mots-clés entrés par l'utilisateur
     * @return array
     */
    function search($keywords) {
        $search = explode(" ", $keywords);
        $productsQuery = "SELECT produits.id, produits.nom, familles.id AS idFamille, familles.nom AS nomFamille, description, image, prix, stock FROM produits JOIN familles ON idFamille = familles.id";
        $i = 0;
        foreach ($search as $keyword) {
            if ($i == 0) {
                $productsQuery .= " WHERE ";
            } else {
                $productsQuery .= " AND ";
            }
            $productsQuery .= " produits.nom LIKE '%$keyword%'";
            $i++;
        }
        return $this->db->getDb()->query($productsQuery)->fetchAll();
    }
}
    
