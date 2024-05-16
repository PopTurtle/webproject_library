<?php

namespace API;

/**
 *  Représente une page sur laquelle on peut effectuer des requête, et qui
 *    n'affiche en retour qu'un résultat json par exemple.
 */
abstract class APIPage {
    public const actionKey = "action";
    public const resultKey = "status";

    public static function workData(&$data) {
        static::executeActions($data);
    }

    public static function echoData($data) {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    protected abstract static function executeActions(&$data);

    protected final static function tryActions(&$data, $actions) : string {
        if (!isset($data[static::actionKey])) {
            return "no action";
        }
        $dataAction = $data[static::actionKey];
        foreach ($actions as $action => $infos) {
            if (strcmp($action, $dataAction) === 0) {
                if (isset($infos["require"]) && !static::meetRequirement($data, $infos["require"])) {
                    return "no content";
                }
                return $infos["callback"]($data);
            }
        }
        return "unknown action";
    }

    private static function meetRequirement($data, $requirements) : bool {
        foreach ($requirements as $r) {
            if (!isset($data[$r])) {
                return false;
            }
        }
        return true;
    }
}
