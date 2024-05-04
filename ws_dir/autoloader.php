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
 *    ensureCorrectData() pour tous les DBObjects
 *    Administrateur -x
 *    -- Valider l'emprunt du panier
 *    <title> de toutes les pages
 *    Supprimer login.css (Constants et fichier) ainsi que LoginController.php
 *    Déplacer le SessionManager ?
 *    trySelectObj :: return null en cas d'erreur ?
 *    fix bookloan return/renew
 */
