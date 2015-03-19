<?php

function getEntityManager(){
    require_once __DIR__.'\..\vendor\autoload.php';
    require __DIR__.'\..\config\config.php';

    $entitiesPath = array(__DIR__.'\..\Entity');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($entitiesPath,$dev);
    $entityManager = \Doctrine\ORM\EntityManager::create($dbParams,$config);
    return $entityManager;
}