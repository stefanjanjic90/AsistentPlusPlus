<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\NapomenaGrupa;

class NapomenaGrupaServis {

    private $entityManager;
    private $repository;
    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\NapomenaGrupa');
    }

    public function pronadjiNapomenuGrupe($grupa){
        return $this->repository->find($grupa);
    }

    public function upisiNapomenuGrupe(NapomenaGrupa $napomenaGrupaEntity)
    {
        $this->entityManager->persist($napomenaGrupaEntity);
        $this->entityManager->flush();
    }
} 