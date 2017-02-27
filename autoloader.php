<?php
/**
 * Permet d'effectuer l'auto-chargement des classes
 * @param string $class Le nom de la classe
 */
function __autoload($class) {
    require_once "classes/$class.php";
}
