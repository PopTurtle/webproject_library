<?php

// Autoloader

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

// Code nécessaire

Database::ensureConnection();
SessionManager::ensureUserConnectionAttempt();
