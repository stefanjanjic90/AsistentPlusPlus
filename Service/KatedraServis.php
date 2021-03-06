<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\Katedra;

class KatedreServis {

    private $entityManager;
    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Katedra');
    }

    public function pronadjiSveKatedre(){
        return $this->repository->findAll();
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function unesiKatedru(Katedra $katedraEntity)
    {
        $this->entityManager->persist($katedraEntity);
        $this->entityManager->flush();
    }
} 