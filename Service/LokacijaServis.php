<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\Lokacija;

class LokacijaServis {

    private $entityManager;
    private $repository;
    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Lokacija');
    }

    public function pronadjiSve(){
        return $this->repository->findAll();
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiPoSifri($sifra){
        $query = $this->entityManager->createQuery(
            ' SELECT lok FROM AsistentPlusPlus\Entity\Lokacija lok WHERE lok.sifra=:sifra ');
        $query->setParameter('sifra',$sifra);
        return $query->getResult();
    }

    public function pronadjiPoAdresi($adresa){
        $query = $this->entityManager->createQuery(
            ' SELECT lok FROM AsistentPlusPlus\Entity\Lokacija lok WHERE lok.adresa=:adresa ');
        $query->setParameter('adresa',$adresa);
        return $query->getResult();
    }

    public function unesi(Lokacija $lokacijaEntity)
    {
        $this->entityManager->persist($lokacijaEntity);
        $this->entityManager->flush();
    }
} 