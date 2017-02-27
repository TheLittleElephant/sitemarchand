<?php
/**
 * Classe permettant la gestion des messages de succès, d'erreur, d'avertissement et d'information (flash messages)
 * @version 1.0
 * @since 06/05/2016
 * @author Jonathan
 */
class Messages {
    
    /**
     * Construit l'objet Messages et démarre la session si elle n'est pas déjà démarrée
     */
    function __construct() {
        if(!session_id()) {
            session_start();
        }
    }

    /**
     * Permet d'afficher une erreur
     * @param string $text Texte du message
     * @return string
     */
    static function error($text) {
        return '<div class="alert alert-danger alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>'.$text.'</div>';
    }
    /**
     * Permet d'afficher un avertissement
     * @param string $text Texte du message
     * @return string
     */
    static function warning($text) {
        return '<div class="alert alert-warning alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>'.$text.'</div>';
    }
    /**
     * Permet d'afficher un succès
     * @param string $text Texte du message
     * @return string
     */
    static function success($text) {
        return '<div class="alert alert-success alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>'.$text.'</div>';
    }
    /**
     * Permet d'afficher une information
     * @param string $text Texte du message
     * @return string
     */
    static function info($text) {
        return '<div class="alert alert-info alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>'.$text.'</div>';
    }
    
    /**
     * Ajoute un message
     * @param string $type Type du message
     * @param string $message Texte du message
     */
    function add($type, $message) {
        if($type == "error" || $type == "warning" || $type == "info" || $type == "success") {
            $_SESSION["message"] = array("type" => $type, "message" => $message);
        }  
    }
    
    /**
     * Affiche le message puis le détruit
     */
    function show() {
        if(isset($_SESSION["message"])) {
            echo self::$_SESSION["message"]["type"]($_SESSION["message"]["message"]);
            unset($_SESSION["message"]);
        }
    }
    
}
