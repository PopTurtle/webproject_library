<?php

namespace App\Utils;

/**
 *  Fais de ses classes dérivées des singlotons.
 */
abstract class Singleton {
    /**  Instance courante, unique, peut être null */
    private static $_instances;

    /**
     *  Accès à l'instance unique, si elle existe
     *  @return ?static
     */
    public static function Instance() {
        if (!isset(static::$_instances[static::class])) {
            static::createInstance();
        }
        return static::$_instances[static::class];
    }

    protected abstract function __construct();

    /**  Méthode appelée pour créer l'instance */
    private static function createInstance() {
        static::$_instances[static::class] = new static();
    }
}
