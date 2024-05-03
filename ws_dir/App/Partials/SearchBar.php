<?php

namespace App\Partials;

use App\Constants;
use App\Partials\Partial;

class SearchBar extends Partial {
    public const ASSOCIATED_STYLE = Constants::STYLE_SEARCHBAR;

    /**
     *  @param $args :
     *    - action_ref : défini la page d'arrivée (action) du formulaire de
     *      recherche, la chaine vide par défaut
     */
    public static function put($args = []) {
        ?>
        <div class="search-bar">
            <form method="get" action="<?= $args['action_ref'] ?? '' ?>">
                <input
                    class="sb-text"
                    type="text"
                    value="<?= $args["search_data"] ?? '' ?>"
                    name="search-data"
                    placeholder="Rechercher un livre"
                    autocomplete="off"
                    >
                <select class="sb-drop" name="search-type">
                    <option value="<?= Constants::SEARCH_TYPE_TITLE ?>">Par titre</option>
                    <option value="<?= Constants::SEARCH_TYPE_AUTHOR ?>">Par auteur</option>
                    <option value="<?= Constants::SEARCH_TYPE_CATEGORY ?>">Par catégorie</option>
                </select>
                <input class="sb-search" type="submit" value="Rechercher">
            </form>
        </div>
        <?php
    }
}
