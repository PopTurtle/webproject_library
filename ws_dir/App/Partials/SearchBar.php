<?php

namespace App\Partials;

use App\Constants;

class SearchBar {
    public static function putSearchBar(string $action_ref) {
        ?>
        <div class="search-bar">
            <form method="get" action=<?= $action_ref ?>>
                <input class="sb-text" type="text" name="search-data" placeholder="Rechercher un livre">
                <select class="sb-drop" name="search-type">
                    <option value="title">Titre</option>
                    <option value="author">Auteur</option>
                    <option value="category">Catégorie</option>
                </select>
                <input class="sb-search" type="submit" value="Rechercher">
            </form>
        </div>
        <?php
    }

    public static function putSearchBarStyle() {
        ?>
        <link rel="stylesheet" href="<?= Constants::STYLE_SEARCHBAR ?>">
        <?php
    }
}
