<?php

require_once __DIR__.'\..\src\bootstrap.php';
$katedre = $entityManager->getRepository('AsistentPlusPlus\Entity\Katedra')->findAll();
$lokacije = $entityManager->getRepository('AsistentPlusPlus\Entity\Lokacija')->findAll();
$sale = $entityManager->getRepository('AsistentPlusPlus\Entity\Sala')->findAll();
$nalog = $entityManager->getRepository('AsistentPlusPlus\Entity\Nalog')->findAll();
$obaveza = $entityManager->getRepository('AsistentPlusPlus\Entity\Obaveza')->findAll();
$najavljenaGrupa = $entityManager->getRepository('AsistentPlusPlus\Entity\NajavljenaGrupa')->findAll();
$najavljenaGrupaSala = $entityManager->getRepository('AsistentPlusPlus\Entity\NajavljenaGrupaSala')->findAll();
$zakazanaGrupa = $entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupa')->findAll();
$predmetniAsistentiNaObavezi = $entityManager->getRepository('AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi')->findAll();

$zakazanaGrupaSala = $entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupaSala')->findAll();
$napomenaGrupa = $entityManager->getRepository('AsistentPlusPlus\Entity\NapomenaGrupa')->findAll();
$ponudjeneZamene = $entityManager->getRepository('AsistentPlusPlus\Entity\PonudjeneZamene')->findAll();
$napomenaGrupaDezurni = $entityManager->getRepository('AsistentPlusPlus\Entity\NapomenaGrupaDezurni')->findAll();
$zakazanaGrupaDezurni = $entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupaDezurni')->findAll();

echo"DONE";