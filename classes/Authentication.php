<?php
/**
 * Classe permettant la gestion de l'authentification au site
 * @version 1.0
 * @since 07/05/2016
 * @author Jonathan
 */

class Authentication {
    
    /**
     * Contient l'objet Database
     * @var Database
     */
    private $db;
    
    /**
     * Constante définissant la durée maximale (en secondes) d'une session
     */
    const SESSION_TIME = 300;
    
    /**
     * Construit l'objet Authentication, initialise les propriétés puis démarre la session s'il est n'est pas déjà démarrée et construit l'utilisateur s'il n'existe pas
     * @param Database $db Permet d'accéder aux méthodes de la classe Database
     */
    function __construct(Database $db) {
        if(!session_id()) {
            session_start();
        }
        if (!isset($_SESSION["user"])) {
            $_SESSION["user"] = array();
        }
        
        $this->db = $db;
    }

    /**
     * Vérifie les identifiants de l'utilisateur
     * @param string $post_submit Bouton de validation du formulaire
     * @param string $post_username Nom de l'utilisateur
     * @param string $post_password Mot de passe de l'utilisateur
     * @return boolean
     */
    function userLogin($post_submit, $post_username, $post_password) {
        if(isset($_POST[$post_submit]) && isset($_POST[$post_username]) && isset($_POST[$post_password])
                && !empty($_POST[$post_username]) && !empty($_POST[$post_password])) {
            echo $username = htmlspecialchars($_POST[$post_username]);
            echo $password = md5(htmlspecialchars($_POST[$post_password]));
            if($this->db->getDb()->query("SELECT id, CONCAT(prenom, ' ', nom) AS nom, login, mdp FROM clients WHERE login = '$username' AND mdp = '$password'")->rowCount() == 1) {
                $user = $this->db->getDb()->query("SELECT id, CONCAT(prenom, ' ', nom) AS nom, login, mdp, role FROM clients WHERE login = '$username' AND mdp = '$password'")->fetchObject();
                $_SESSION["user"] = array("id" => $user->id, "name" => $user->nom, "login" => $user->login, "password" => $user->mdp, "role" => $user->role , "time" => time());
                return true;   
            }
        }
        return true;
    }
    
    /**
     * Retourne le client
     * @return array
     */
    function getUser() {
        return $_SESSION["user"];
    }
    
    /**
     * Vérifie si l'utilisateur est connecté
     * @return boolean
     */
    function isLogged() {
        if(isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            return true;
        }
        return false;
    }
    
    /**
     * Vérifie si l'utilisateur a les droits pour accéder à l'interface d'administration
     * @return boolean
     */
    function isGranted() {
        if($_SESSION["user"]["role"] == "ADMIN") {
            return true;
        }
        return false;
    }
    
    /**
     * Retourne le nom du client
     * @return string
     */
    function getUsername() {
        return $_SESSION["user"]["name"];
    }
    
    /**
     * Retourne l'ID du client
     * @return int
     * @static
     */
    static function getUserId() {
        return $_SESSION["user"]["id"];
    }
    
    /**
     * Déconnecte le client
     */
    function logout() {
        $_SESSION = array();
        session_destroy();
    }
    
    /**
     * Vérifie si la session dure plus que la valeur de la constante SESSION_TIME
     * @return boolean
     */
    function sessionTimeIsOver() {
        if(time() - $_SESSION["user"]["time"] > self::SESSION_TIME) {
            return true;
        }
        return false;
        
    }
}
