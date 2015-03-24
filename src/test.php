<?php
require_once __DIR__.'\..\src\bootstrap.php';
require_once __DIR__.'\..\src\autoload.php';

/*$nalogServis = new \AsistentPlusPlus\Service\NalogServis();
$andj = $nalogServis->pronadjiPoKorisnickomImenu("andjelkaz");


$aut = $nalogServis->autentifikacijaKorisnika("andjelkaz","andjejlka");

$sviKorisnici = $nalogServis->pronadjiSveKorisnike();

$salaServis = new \AsistentPlusPlus\Service\SalaServis();

$salaEntity = new \AsistentPlusPlus\Entity\Sala();

$lokacija = $entityManager->getRepository('AsistentPlusPlus\Entity\Lokacija')->find(1);

$zakGrupe = $entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupa')->findAll();

$salaEntity->setKapacitet(50);
$salaEntity->setLokacija($lokacija);
$salaEntity->setOznaka("806");
$salaEntity->setRacunariKapacitet(0);

//$salaServis->unesiSalu($salaEntity);

$katedraServis = new \AsistentPlusPlus\Service\KatedreServis();

$sveKatedre = $katedraServis->pronadjiSveKatedre();

$najavljenaGrupaServis = new AsistentPlusPlus\Service\NajavljenaGrupaServis();
$najavljeneGrupePoObavezi = $najavljenaGrupaServis->pronadjiSvePoObavezi(1);*/

$kontroler1=new \AsistentPlusPlus\Controller\KatedraKontroler();

echo $kontroler1->vratiSveKatedre();

echo "DONE!";