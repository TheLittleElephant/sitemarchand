<?php
require_once '../../autoloader.php';
//On demande le fichier contenant les constantes
require_once '../../constants.php';
$db = new Database();
$messages = new Messages();
$dashboard = new Dashboard($db, $messages);
//On passe à la méthode les noms des champs 
if($dashboard->addUser("submit", "lname", "fname", "username", "password", "role")) {
    //On ajoute un message
    $messages->add("success", USER_ADDED);
    header("Location: ../index");
} else {
    $messages->add("error", USER_NOT_ADDED);
    header("Location: ../index");
}
