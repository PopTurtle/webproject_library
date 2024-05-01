<?php

//  Autoloader

use App\Controller\SessionManager;
use App\Model\Database;

const app = "/App";
const ns_cut_preg = "/^App/";

function autoload($class) {
    $rpath = str_replace("\\", '/', preg_replace(ns_cut_preg, "", $class));
    $fn = __DIR__ . app . $rpath . ".php";
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
 *    -- Page renouveler emprunt
 *    -- Page rendre un livre
 *    Administrateur -x
 *    -- Valider l'emprunt du panier
 *    <title> de toutes les pages
 */
