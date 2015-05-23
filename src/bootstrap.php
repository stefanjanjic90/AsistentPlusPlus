<?php

class Bootstrap
{
    private static $entityManger = null;
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized) {
            return;
        } else {
            require_once __DIR__ . '\..\vendor\autoload.php';
            require __DIR__ . '\..\config\config.php';
            $entitiesPath = array(__DIR__ . '\..\Entity');
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($entitiesPath, $dev);
            self::$entityManger = \Doctrine\ORM\EntityManager::create($dbParams, $config);
            self::$initialized = true;
        }
    }

    public static function getEntityManager()
    {
        self::initialize();
        return self::$entityManger;
    }

    private function __clone(){}
    private function __wakeup(){}
    private function __construct() {}
}

?>