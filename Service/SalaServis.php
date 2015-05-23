<?php

namespace AsistentPlusPlus\Service;
use AsistentPlusPlus\Entity\Sala;

class SalaServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Sala');
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiSveSale(){
        return $this->repository->findAll();
    }

    public function unesiSalu(Sala $salaEntity){
        $this->entityManager->persist($salaEntity);
        $this->entityManager->flush();
    }

    public function azurirajSalu(Sala $salaEntity){
        $this->entityManager->merge($salaEntity);
        $this->entityManager->flush();
    }
} 