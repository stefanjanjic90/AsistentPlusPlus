<?php
session_start();
require_once __DIR__.'\vendor\autoload.php';
use AsistentPlusPlus\Controller\DezurstvaKontroler;
use AsistentPlusPlus\Controller\KatedraKontroler;
use AsistentPlusPlus\Controller\KorisniciKontroler;
use AsistentPlusPlus\Controller\SalaKontroler;
use AsistentPlusPlus\Controller\ZakazanaGrupaKontroler;
use AsistentPlusPlus\Controller\AdministracijaKontroler;
include 'Router.php';

$router = new Router();

$dezurstvaKontroler = new DezurstvaKontroler();
$router->addPublicRoute("satiNaDezurstvu(?:/([_A-Za-z0-9]+))?", $dezurstvaKontroler, "satiNaDezurstvu");

$router->addPrivateRoute("glavnaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "glavnaDezurstva");
$router->addPrivateRoute("sporednaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "sporednaDezurstva");
$router->addPrivateRoute("zavrsenaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "zavrsenaDezurstva");
$router->addPrivateRoute("ponudjeneZamene/([_A-Za-z0-9]+)/([1-9][0-9]*)", $dezurstvaKontroler, "ponudjeneZamene");
$router->addPrivateRoute("moguceZamene/([0-9]{4}\\-[0-9]{2}\\-[0-9]{2})/([0-9]{2}:[0-9]{2})", $dezurstvaKontroler, "moguceZamene");

$katedraKontroler = new KatedraKontroler();
$router->addPrivateRoute("katedre", $katedraKontroler, "vratiSveKatedre");

$korisniciKontroler = new KorisniciKontroler();
$router->addPrivateRoute("korisnici", $korisniciKontroler, "vratiSveKorisnike");

$salaKontroler = new SalaKontroler();
$router->addPrivateRoute("ucionice", $salaKontroler, "vratiSveSale");

$administracijaKontroler = new AdministracijaKontroler();
$router->addPrivateRoute("info", $administracijaKontroler, "info");

$zakazanaGrupaKontroler = new ZakazanaGrupaKontroler();
$router->addPublicRoute("raspored", $zakazanaGrupaKontroler, "vratiZakazaneGrupe");
$router->add("komentari/([_A-Za-z0-9]+)", $zakazanaGrupaKontroler, "vratiNapomeneZaAsistenta");

if(!isset($_SESSION['LoggedIn']) && !isset($_SESSION['Username']) && !isset($_POST['inputUN']) && !isset($_POST['inputP'])){
    $router->routeRequest(false);
}elseif(isset($_POST['inputUN']) && isset($_POST['inputP'])){
    $router->logInUser();
}else{
    $router->routeRequest(true);
}

