<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\Obaveza;

class ObavezaServis {

    private $entityManager;
    private $repository;
    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Obaveza');
    }

    public function pronadjiSve(){
        return $this->repository->findAll();
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiPoNazivu($naziv){
        $query = $this->entityManager->createQuery('SELECT o FROM AsistentPlusPlus\Entity\Obaveza o WHERE o.nazivObaveze=:naziv');
        $query->setParameter('naziv',$naziv);
        return $query->getResult();
    }

    public function unesi(Obaveza $obavezaEntity)
    {
        $this->entityManager->persist($obavezaEntity);
        $this->entityManager->flush();
    }
} 