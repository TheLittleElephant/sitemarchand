<?php
require_once '../autoloader.php';
require_once '../constants.php';
$db = new Database();
$messages = new Messages();
$authentication = new Authentication($db);
//On passe à la méthode les noms des champs 
if($authentication->userLogin("submit", "username", "password")) {
    //On ajoute un message
    $messages->add("success", GOOD_CREDENTIALS);
    header("Location: ../index");
} else {
    $messages->add("error", BAD_CREDENTIALS);
    header("Location: ../login");
}
