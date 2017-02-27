<?php
//On demande à l'autoloader de charger les classes
require_once 'autoloader.php';
//On a besoin d'un objet Database pour créer un objet Authentication et Cart
$db = new Database();
//Puis on construit les objets Messages et Cart
$messages = new Messages();
$cart = new Cart($db, $messages);
//On construit un objet Authentication
$authentication = new Authentication($db);
//On vérifie si l'utilisateur est bien connecté ou si la session n'a pas atteint la durée maximale
if(!$authentication->isLogged() || $authentication->sessionTimeIsOver()) {
    //On déconnecte l'utilisateur
    $authentication->logout();
    //On redirige vers la page de connexion
    header("Location: login");
}
//On récupére les familles (IDs et noms)
$categories = $db->getCategories();
//On inclut l'header de la page
include 'include/header.php';
//On affiche les messages s'il y en a
$messages->show();
if(isset($_GET["cat"]) && !empty($_GET["cat"])) {
    $category = htmlspecialchars($_GET["cat"]);
    //On récupère les produits de la famille demandée
    $products = $db->getProductsByCategory($category);
    //On affiche les produits
    include 'include/products.php';
}
if(isset($_GET["q"]) && !empty($_GET["q"])) {
    //On récupère les mots-clés 
    $keywords = htmlspecialchars($_GET["q"]);
    //On récupère les produits correpondant aux mots-clés entrés
    $products = $db->search($keywords);
    //On affiche les produits
    include 'include/products.php';
}
//On inclut le footer
include 'include/footer.php';


    

