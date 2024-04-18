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
    public const PAGE_ERROR = "/view/misc/error.php";
    public const PAGE_LOGIN = "/view/user/login.php";
    public const PAGE_PROFILE = "/view/user/profile.php";

    /**
     *  Chemin des feuilles de style
     */
    public const STYLE_GLOBAL = "/style/global.css";
    public const STYLE_INDEX = "/style/index.css";
    public const STYLE_NAVBAR = "/style/navbar.css";
    public const STYLE_SEARCHBAR = "/style/searchbar.css";
}
