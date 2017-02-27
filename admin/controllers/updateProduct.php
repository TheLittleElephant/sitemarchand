<?php
require_once '../../autoloader.php';
//On demande le fichier contenant les constantes
require_once '../../constants.php';
$db = new Database();
$messages = new Messages();
$dashboard = new Dashboard($db, $messages);
//On passe à la méthode les noms des champs 
if($dashboard->updateProduct("submit", "id", "image", "name", "category", "description", "price", "stock")) {
    //On ajoute un message
    $messages->add("success", PRODUCT_MODIFIED);
    header("Location: ../index");
} else {
    $messages->add("error", PRODUCT_NOT_MODIFIED);
    header("Location: ../index");
}
