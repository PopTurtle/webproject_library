<?php

namespace App\Utils;

/**
 *  Fais de ses classes dérivées des singlotons.
 */
abstract class Singleton {
    /**  Instance courante, unique, peut être null */
    private static $_instance;

    /**
     *  Accès à l'instance unique, si elle existe
     *  @return ?static
     */
    public static function Instance() {
        if (static::$_instance == null) {
            static::createInstance();
        }
        return static::$_instance;
    }

    protected function __construct() { ; }

    /**
     *  Méthode appelée pour créer l'instance, si possible elle doit être
     *    attachée à static::$_instance.
     */
    protected static function createInstance() {
        static::$_instance = new static();
    }
}
