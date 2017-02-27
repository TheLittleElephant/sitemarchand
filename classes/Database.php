<?php
/**
 * Classe permettant de gérer les requêtes vers la base de données
 * @version 1.0
 * @since 06/05/2016
 * @author Jonathan
 */
class Database {
    
    /**
     * Contient l'objet PDO 
     * @var PDO Contient l'objet PDO
     */
    public $db;
    
    /**
     * Constante définissant le nombre de produits pouvant être affichés sur l'interface d'administration
     */
    const NUMBER_OF_PRODUCTS_SHOWED = 5;
    
    /**
     * Construit l'objet Database et initialise la propriété $db 
     */
    function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=sitemarchand;charset=utf8;", "root", "");
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } 
    }
    
    /**
     * Retourne la connexion à la base de données
     * @return PDO
     */
    function getDb() {
        return $this->db;
    }
    
    /**
     * Retourne le nombre de familles
     * @return int
     */
    function categoriesCount() {
        return $this->db->query("SELECT COUNT(*) AS number FROM familles")->fetchObject()->number;
    }
    
    /**
     * Retourne le nombre de produits
     * @return int
     */
    function productsCount() {
        return $this->db->query("SELECT COUNT(*) AS number FROM produits")->fetchObject()->number;
    }
    
    /**
     * Retourne les catégories de produits
     * @return array
     */
    function getCategories() {
        return $this->db->query("SELECT id, nom FROM familles ORDER BY id")->fetchAll();
    }
    
    /**
     * Retourne tous les produits et leurs familles
     * @return array
     */
    function getAllProducts() {
        return $this->db->query("SELECT produits.id, produits.nom, familles.id AS idFamille, familles.nom AS nomFamille, description, image, prix, stock FROM produits JOIN familles ON idFamille = familles.id ORDER BY produits.id")->fetchAll();
    }
    
    /**
     * Retourne les produits en fonction de leur catégorie
     * @param int $category Catégorie du produit
     * @return array
     */
    function getProductsByCategory($category) {
        return $this->db->query("SELECT produits.id, produits.nom, description, image, prix, stock FROM produits JOIN familles ON idFamille = familles.id WHERE idFamille = '$category' ORDER BY produits.id")->fetchAll();
    }
    
    /**
     * Retourne les produits en limitant le nombre de résultats grâce à la clause LIMIT
     * @param int $limit
     * @param int $productsNumberToShow
     * @return array
     */
    function getProductsWithLimit($limit, $productsNumberToShow = self::NUMBER_OF_PRODUCTS_SHOWED) {
        return $this->db->query("SELECT produits.id, produits.nom, familles.id AS idFamille, familles.nom AS nomFamille, description, image, prix, stock FROM produits JOIN familles ON idFamille = familles.id ORDER BY produits.id DESC LIMIT $limit, $productsNumberToShow")->fetchAll();
    }
    
    /**
     * Retourne les utilisateurs
     * @return array
     */
    function getUsers() {
        return $this->db->query("SELECT id, nom, prenom, login, mdp, role FROM clients ORDER BY id")->fetchAll();
    }
    
    /**
     * Retourne les rôles possibles pour les utilisateurs
     * @return array
     */
    function getUsersRoles() {
        return $this->db->query("SELECT role FROM clients ORDER BY id")->fetchAll();
    }
    
    /**
     * Recherche dans la base de données un ou plusieurs produits en fonction des mots-clés entrés par l'utilisateur
     * @param string $keywords Mots-clés entrés par l'utilisateur
     * @return array
     */
    function search($keywords) {
        $search = explode(" ", $keywords);
        $productsQuery = "SELECT produits.id, produits.nom, description, image, prix, stock FROM produits JOIN familles ON idFamille = familles.id";
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
        return $this->db->query($productsQuery)->fetchAll();
    }
    
    
}
