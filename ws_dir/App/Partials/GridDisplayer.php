<?php

namespace App\Partials;

use App\Constants;
use App\Partials\Partial;

class GridDisplayer extends Partial {
    public const ASSOCIATED_STYLE = Constants::STYLE_GRID_DISPLAYER;

    /**
     *  @param $args :
     *    - section : "start" ou "end" : Début ou fin du display
     */
    public static function put($args = []) {
        if (isset($args["section"])) {
            switch ($args["section"]) {
                case "start":
                    return self::putStart($args);
                case "end":
                    return self::putEnd($args);
                default:
                    return;
            }
        }
    }

    public static function putStart($args = []) {
        ?>
        <div class="display-frame">
        <?php
    }

    public static function putEnd($args = []) {
        ?>
        </div>
        <?php
    }
}
