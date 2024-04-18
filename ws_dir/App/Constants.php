<?php

namespace App;


/**
 *  Contient des constantes pour le site
 */
abstract class Constants {
    /**
     *  Chemins des pages
     */
    public const PAGE_HOME = "/view/index.php";
    public const PAGE_ERROR = "/view/error.php";
    public const PAGE_LOGIN = "/view/login.php";
    public const PAGE_PROFILE = "/view/profile.php";

    /**
     *  Chemin des feuilles de style
     */
    public const STYLE_GLOBAL = "/view/style/global.css";
    public const STYLE_INDEX = "/view/style/index.css";
    public const STYLE_NAVBAR = "/view/style/navbar.css";
    public const STYLE_SEARCHBAR = "/view/style/searchbar.css";
}
