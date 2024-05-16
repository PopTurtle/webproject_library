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
 *    -- Valider l'emprunt du panier
 *    Fin - CSS - (book / profil / panier)
 *    Fin - Réorganiser les constantes
 *    Fin - Déplacer le SessionManager ? ; Non, probablement pas ?
 *    Fin - pagination de la recherche de livres ? ; peu de chance
 */
