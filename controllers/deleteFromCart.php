<?php
require_once '../autoloader.php';
require_once '../constants.php';
$db = new Database();
$messages = new Messages();
$cart = new Cart($db, $messages);
//On passe à la méthode les noms des champs 
if($cart->deleteFromCart("submit", "index")) {
    //On ajoute un message
    $messages->add("success", PRODUCT_DELETED);
    header("Location: ../cart");
} else {
    $messages->add("error", PRODUCT_NOT_DELETED);
    header("Location: ../cart");
}
