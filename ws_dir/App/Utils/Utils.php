<?php

namespace App\Utils;

use App\Constants;

/**
 *  Donne accès à quelques méthodes utilitaires
 */
class Utils {
    /**  Génère le hash du mot de passe $password */
    public static function generatePasswordHash(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**  Vérifie que le mot de passe $password est conforme au hash $hash */
    public static function testPassword(string $password, string $hash) {
        return password_verify($password, $hash);
    }

    /**
     *  Redirige vers la page située au chemin $path, en passant les arguments
     *    dont les noms sont les clés / valeurs sont celles données par
     *    $argsGet
     */
    public static function redirectTo(string $path, $argsGet) {
        $argsArr = [];
        foreach ($argsGet as $k => $v) {
            array_push($argsArr, $k . "=" . $v);
        }
        $argsStr = implode("&", $argsArr);
        header(
            "Location: " . $path
            . "?" . $argsStr
        );
    }

    /**
     *  Redigirge vers une page d'erreur avec le code d'erreur $code et le
     *    message d'erreur $msg. Il est supposé que la méthode est appelée avant
     *    l'affichage de tout code HTML
     */
    public static function showErrorCode($code, $msg) {
        self::redirectTo(Constants::PAGE_ERROR, ["code" => $code, "msg" => $msg]);
    }
}
