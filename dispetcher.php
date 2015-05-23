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
$router->addPublicRoute("satiNaDezurstvu(?:/([_A-Za-z0-9]+))?", "GET",$dezurstvaKontroler, "satiNaDezurstvu");

$router->addPrivateRoute("glavnaDezurstva/([_A-Za-z0-9]+)", "GET",$dezurstvaKontroler, "glavnaDezurstva");
$router->addPrivateRoute("sporednaDezurstva/([_A-Za-z0-9]+)", "GET",$dezurstvaKontroler, "sporednaDezurstva");
$router->addPrivateRoute("zavrsenaDezurstva/([_A-Za-z0-9]+)", "GET",$dezurstvaKontroler, "zavrsenaDezurstva");
$router->addPrivateRoute("ponudjeneZamene/([_A-Za-z0-9]+)/([1-9][0-9]*)", "GET",$dezurstvaKontroler, "ponudjeneZamene");
$router->addPrivateRoute("moguceZamene/([0-9]{4}\\-[0-9]{2}\\-[0-9]{2})/([0-9]{2}:[0-9]{2})", "GET",$dezurstvaKontroler, "moguceZamene");
$router->addPrivateRoute("otkaziObavezu/([1-9][0-9]*)","GET",$dezurstvaKontroler,"otkaziObavezu");

$katedraKontroler = new KatedraKontroler();
$router->addPrivateRoute("katedre","GET",$katedraKontroler, "vratiSveKatedre");

$korisniciKontroler = new KorisniciKontroler();
$router->addPrivateRoute("korisnici", "GET",$korisniciKontroler, "vratiSveKorisnike");
$router->addPrivateRoute("novi_korisnik","POST",$korisniciKontroler,"dodajNovogKorisnika");

$salaKontroler = new SalaKontroler();
$router->addPrivateRoute("ucionice", "GET",$salaKontroler, "vratiSveSale");
$router->addPrivateRoute("ucionica", "POST",$salaKontroler, "unesiUcionicu");

$administracijaKontroler = new AdministracijaKontroler();
$router->addPrivateRoute("info","GET", $administracijaKontroler, "info");
$router->addPrivateRoute("info","POST", $administracijaKontroler, "sacuvajInfo");

$zakazanaGrupaKontroler = new ZakazanaGrupaKontroler();
$router->addPublicRoute("raspored/([0-9]{4}\\-[0-9]{2}\\-[0-9]{2})", "GET",$zakazanaGrupaKontroler, "vratiZakazaneGrupe");
$router->addPrivateRoute("komentari/([_A-Za-z0-9]+)", "GET",$zakazanaGrupaKontroler, "vratiNapomeneZaAsistenta");

if(!isset($_SESSION['LoggedIn']) && !isset($_SESSION['Username']) && !isset($_POST['inputUN']) && !isset($_POST['inputP'])){
    $router->routeRequest(false);
}elseif(isset($_POST['inputUN']) && isset($_POST['inputP'])){
    $router->logInUser();
}else{
    $router->routeRequest(true);
}

