<?php

namespace App\Partials;


/**
 *  Représente un partial, bout de code HTML, dont on peut afficher le contenu
 *    ou lié le style associé.
 */
abstract class Partial {
    /**  Correspond au chemin vers le fichier de style associé */
    public const ASSOCIATED_STYLE = "";

    /**  Affiche le contenu du partial */
    public abstract static function put($args);
    
    /**  Lie le fichier css associé au partial */
    public static function putHeader() {
        if (strcmp(static::ASSOCIATED_STYLE, "") != 0) {
            static::putStyleLink(static::ASSOCIATED_STYLE);
        }
    }

    protected static function putStyleLink(string $stylePath) {
        ?>
        <link rel="stylesheet" href="<?= $stylePath ?>">
        <?php
    }
}
