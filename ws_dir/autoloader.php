<?php

//  Autoloader

use App\Controller\SessionManager;
use App\Model\Database;

const app = "/App";
const ns_cut_preg = "/^App/";

function autoload($class) {
    $rpath = str_replace("\\", "/", $class);
    $fn = __DIR__ . "/" . $rpath . ".php";
    require_once $fn;
}

define("__ROOT", __DIR__);

spl_autoload_register("autoload");

//  Code nécessaire
//  Donner une valeur quelconque à $removeNecessaryCode
//    pour ne pas executer ce code

if (!isset($removeNecessaryCode)) {
    Database::ensureConnection();
    SessionManager::ensureUserConnectionAttempt();
}

/**
 *  TODO:
 *    book.php : on peut ajouter un livre déjà emprunter au panier
 *      -- Il faut l'empecher
 *      -- Ne pas permettre la validation d'un panier si un livre est déjà emprunter
 *    Fin - tenter de réduire les :has()
 *    Fin - Réorganiser les constantes
 */
