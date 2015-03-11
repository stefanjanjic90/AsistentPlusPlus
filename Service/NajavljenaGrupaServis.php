<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\NajavljenaGrupa;

class NajavljenaGrupaServis {


    private $entityManager;
    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\NajavljenaGrupa');
    }

    public function pronadjiPoRbrNajave($rbrNajave){
        return $this->repository->find($rbrNajave);
    }

    public function pronadjiSvePoObavezi($obavezaId){
        $query = $this->entityManager->createQuery(
                        ' SELECT ng FROM '
                        .' AsistentPlusPlus\Entity\NajavljenaGrupa ng '
                        .' JOIN AsistentPlusPlus\Entity\Obaveza o '
                        .' WHERE ng.obaveza = o.id AND o.id = :obavezaId ');

        $query->setParameter('obavezaId',$obavezaId);

        return $query->getResult();
    }

    public function unesi(NajavljenaGrupa $najavljenaGrupaEntity)
    {
        $this->entityManager->persist($najavljenaGrupaEntity);
        $this->entityManager->flush();
    }
}