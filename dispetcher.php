<?php
require_once __DIR__.'\vendor\autoload.php';
include 'Router.php';
use AsistentPlusPlus\Controller\NajavljenaGrupaKontroler;


$router = new Router();

$router->add("najavljenaGrupa/get(/([0-9]+))?", new NajavljenaGrupaKontroler(), "getGrupa");

$router->routeRequest();

echo '<br> In Dispecher';

