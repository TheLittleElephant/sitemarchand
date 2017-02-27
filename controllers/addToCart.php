<?php
require_once '../autoloader.php';
require_once '../constants.php';
$db = new Database();
$messages = new Messages();
$cart = new Cart($db, $messages);
//On passe à la méthode les noms des champs 
if(!$cart->addToCart("submit", "id", "name", "quantity", "price")) {
    //On ajoute un message
    $messages->add("error", PRODUCT_NOT_ADDED);
    header("Location: ../cart");
}


