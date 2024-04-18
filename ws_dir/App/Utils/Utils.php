<?php

namespace App\Utils;

use App\Constants;

class Utils {
    public static function generatePasswordHash(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function testPassword(string $password, string $hash) {
        return password_verify($password, $hash);
    }

    public static function showErrorCode($code, $msg) {
        header(
            "Location: " . Constants::PAGE_ERROR . "?" .
            "code=" . $code . "&" .
            "msg=" . $msg
        );
    }
}
