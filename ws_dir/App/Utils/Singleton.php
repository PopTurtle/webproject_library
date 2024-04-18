<?php

namespace App\Utils;

class Singleton {
    private static $_instance;

    protected function __construct() { ; }

    public static function Instance() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        if (static::$_instance == null) {
            static::createInstance();
        }
        return static::$_instance;
    }

    protected static function createInstance() {
        static::$_instance = new static();
    }
}
