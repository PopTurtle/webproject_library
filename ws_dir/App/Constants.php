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
    public const PAGE_BOOKSEARCH = "/view/booksearch.php";
    public const PAGE_BOOK = "/view/book.php";

    /**
     *  Chemins des feuilles de style
     */
    public const STYLE_GLOBAL = "/style/global.css";
    public const STYLE_INDEX = "/style/index.css";
    public const STYLE_NAVBAR = "/style/navbar.css";
    public const STYLE_SEARCHBAR = "/style/searchbar.css";
    public const STYLE_BOOKSEARCH = "/style/booksearch.css";

    /**
     *  Chemins des scripts
     */
    public const SCRIPT_BOOKLOAN = "/App/Scripts/bookloan.js";

    /**
     *  Types de recherche de livres disponible
     */
    public const SEARCH_TYPE_TITLE = "title";
    public const SEARCH_TYPE_AUTHOR = "author";
    public const SEARCH_TYPE_CATEGORY = "category";
}
