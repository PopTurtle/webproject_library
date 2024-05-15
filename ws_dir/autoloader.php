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
 *    Administrateur -x
 *    -- Valider l'emprunt du panier
 *    Déplacer le SessionManager ? ; Non, probablement pas ?
 *    trySelectObj :: return null en cas d'erreur ?
 *    navigation plus simple entre les pages
 *    pagination de la recherche de livres ?
 */
