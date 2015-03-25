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

if(!isset($_SESSION['LoggedIn']) && !isset($_SESSION['Username']) && !isset($_POST['inputUN']) && !isset($_POST['inputP'])){
    $router->userNotLoggedIn();
}elseif(isset($_POST['inputUN']) && isset($_POST['inputP'])){
    $router->logInUser();
}else{
    $dezurstvaKontroler = new DezurstvaKontroler();
    $router->add("glavnaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "glavnaDezurstva");
    $router->add("sporednaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "sporednaDezurstva");
    $router->add("satiNaDezurstvu/([_A-Za-z0-9]+)", $dezurstvaKontroler, "satiNaDezurstvu");
    $router->add("zavrsenaDezurstva/([_A-Za-z0-9]+)", $dezurstvaKontroler, "zavrsenaDezurstva");
    $router->add("ponudjeneZamene/([_A-Za-z0-9]+)/([1-9][0-9]*)", $dezurstvaKontroler, "ponudjeneZamene");

    $katedraKontroler = new KatedraKontroler();
    $router->add("katedre", $katedraKontroler, "vratiSveKatedre");

    $korisniciKontroler = new KorisniciKontroler();
    $router->add("korisnici", $korisniciKontroler, "vratiSveKorisnike");

    $salaKontroler = new SalaKontroler();
    $router->add("ucionice", $salaKontroler, "vratiSveSale");

    $zakazanaGrupaKontroler = new ZakazanaGrupaKontroler();
    $router->add("raspored", $zakazanaGrupaKontroler, "vratiZakazaneGrupe");

    $administracijaKontroler = new AdministracijaKontroler();
    $router->add("info", $administracijaKontroler, "info");

    $router->routeRequest();


}

