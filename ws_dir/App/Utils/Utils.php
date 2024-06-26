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
     *  Renvoie la date d'aujourd'hui.
     */
    public static function getTodayDate() {
        return self::getDateAt(time());
    }

    /**
     *  Renvoie la date telle qu'elle sera dans $days jours. Par défaut la
     *    chaine de fin est "s".
     */
    public static function getDateIn($days): string {
        return self::getDateAt(time() + self::daysInSeconds($days));
    }

    /**
     *  Convertis les jours en secondes.
     */
    public static function daysInSeconds($days): string {
        return $days * 86400;
    }

    /**
     *  Renvoie la date au format (Année)-(Mois)-(Jour) au temps timestamp.
     */
    private static function getDateAt($timestamp): string {
        return date('Y-m-d', $timestamp);
    }

    public static function formatDate($date): string {
        $ds = explode('-', $date);
        if (count($ds) !== 3) {
            return $date;
        }
        return implode('/', [$ds[2], $ds[1], $ds[0]]);
    }

    /**
     *  Redirige vers la page située au chemin $path, en passant les arguments
     *    dont les noms sont les clés / valeurs sont celles données par
     *    $argsGet
     */
    public static function redirectTo(string $path, $argsGet=[]) {
        $argsArr = [];
        foreach ($argsGet as $k => $v) {
            array_push($argsArr, $k . "=" . $v);
        }
        $argsStr = implode("&", $argsArr);
        header(
            "Location: " . $path
            . (count($argsGet) === 0 ? "" : "?" . $argsStr)
        );
        exit(0);
    }

    /**
     *  Redigirge vers une page d'erreur avec le code d'erreur $code et le
     *    message d'erreur $msg. Il est supposé que la méthode est appelée avant
     *    l'affichage de tout code HTML
     */
    public static function showErrorCode($code, $msg) {
        self::redirectTo(Constants::PAGE_ERROR, ["code" => $code, "msg" => $msg]);
    }

    /**
     *  Concatène la chaine $end à $s si count > 1, sinon renvoie $s
     */
    public static function plural(string $s, int $count, string $end="s") {
        return $s . ($count > 1 ? $end : "");
    }

    public static function isNonEmptyString(string $str, int $maxLen = 0) : bool {
        if (strcmp($str, "") === 0) {
            return false;
        }
        return $maxLen <= 0 || strlen($str) <= $maxLen;
    }

    public static function isInt($val, int $min = null, int $max = null) {
        $val = filter_var($val, FILTER_VALIDATE_INT);
        if ($val === false) {
            return false;
        }
        return (is_null($min) || $min <= $val) && (is_null($max) || $val <= $max);
    }

    public static function isCorrectDate($date) {
        $date_r = date_parse($date);
        if ($date_r["error_count"] + $date_r["warning_count"] > 0) {
            return false;
        }
        return checkdate($date_r['month'], $date_r['day'], $date_r['year']);
    }

    public static function isValidMail($mail) {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    public static function getFullAppFolder(): string {
        return __ROOT . "/App";
    }
    
    public static function getFullStorageFolder(): string {
        return self::getFullAppFolder() . "/Storage";
    }

    public static function getRootAppFolder(): string {
        return "/App";
    }

    public static function getRootStorageFolder(): string {
        return self::getRootAppFolder() . "/Storage";
    }
}
