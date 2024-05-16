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
    public const PAGE_SHOPPINGCART = "/view/user/shoppingcart.php";
    public const PAGE_RETURNBOOK = "/view/book_management/return_book.php";
    public const PAGE_RENEWBOOK = "/view/book_management/renew_book.php";
    public const PAGE_ADMIN_LOGIN = "/view/admin/admin_login.php";
    public const PAGE_ADMIN_MAIN = "/view/admin/admin_main.php";
    public const PAGE_ADMIN_ADDBOOK = "/view/admin/admin_addbook.php";
    public const PAGE_ADMIN_ADDUSER = "/view/admin/admin_adduser.php";
    public const PAGE_ADMIN_FORM_TREATMENT = "/view/admin/admin_form_treatment.php";
    public const PAGE_ADMIN_ACTION_BOOK = "/view/admin/admin_action_book.php";
    public const PAGE_ADMIN_DELETE_USER = "/view/admin/admin_delete_user.php";
    public const PAGE_ADMIN_UPDATE_BOOK = "/view/admin/admin_update_book.php";

    /**
     *  Chemins des feuilles de style
     */
    public const STYLE_GLOBAL = "/style/global.css";
    public const STYLE_INDEX = "/style/index.css";
    public const STYLE_NAVBAR = "/style/navbar.css";
    public const STYLE_SEARCHBAR = "/style/searchbar.css";
    public const STYLE_BOOKSEARCH = "/style/booksearch.css";
    public const STYLE_BOOK = "/style/book.css";
    public const STYLE_PROFILE = "/style/profile.css";
    public const STYLE_SHOPPINGCART = "/style/shoppingcart.css";
    public const STYLE_FORM = "/style/misc/form.css";
    public const STYLE_GRID_DISPLAYER = "/style/misc/grid_displayer.css";
    public const STYLE_RENEW_BOOK = "/style/renew_book.css";
    public const STYLE_DISPLAY_BOOK = "/style/misc/display_book.css";
    public const STYLE_ADMIN_DELETE = "/style/admin_delete.css";
    public const STYLE_ADMIN_MAIN = "/style/admin_main.css";

    /**
     *  Chemins des scripts
     */
    public const SCRIPT_BOOK_CARTITEM = "/App/Scripts/book_cartitem.js";
    public const SCRIPT_BOOKLOAN_RETURN = "/App/Scripts/bookloan_return.js";
    public const SCRIPT_BOOKLOAN_RENEW = "/App/Scripts/bookloan_renew.js";
    public const SCRIPT_SHOPPINGCART = "/App/Scripts/shoppingcart.js";
    public const SCRIPT_BOOKSEARCH = "/App/Scripts/booksearch.js";
    public const SCRIPT_ADMIN_DELETE = "/App/Scripts/admin/admin_delete.js";

    /**
     *  Types de recherche de livres disponible
     */
    public const SEARCH_TYPE_TITLE = "title";
    public const SEARCH_TYPE_AUTHOR = "author";
    public const SEARCH_TYPE_CATEGORY = "category";
}
