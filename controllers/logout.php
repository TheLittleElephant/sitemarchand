<?php
require_once '../autoloader.php';
$db = new Database();
$authentication = new Authentication($db);
$authentication->logout();
header("Location: ../login");

