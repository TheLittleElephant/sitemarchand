<?php
require_once '../autoloader.php';
require_once '../constants.php';
$db = new Database();
$messages = new Messages();
$cart = new Cart($db, $messages);
$cart->cartCheckout();
$messages->add("success", CHECKOUT_SUCCESSFUL);
header("Location: ../cart");
