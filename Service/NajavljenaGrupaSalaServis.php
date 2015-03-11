<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\NajavljenaGrupaSala;

class NajavljenaGrupaSalaServis {


    private $entityManager;
    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\NajavljenaGrupaSala');
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiSvePoIdSale($salaId){
        $query = $this->entityManager->createQuery(
            'SELECT ngs FROM '
            .'AsistentPlusPlus\Entity\NajavljenaGrupaSala ngs '
            .'JOIN AsistentPlusPlus\Entity\Sala s '
            .'WHERE ngs.sala = s.id AND s.id = :salaId');

        $query->setParameter('salaId',$salaId);

        return $query->getResult();
    }

    public function pronadjiSvePoOznaciSale($oznakaSale){
        $query = $this->entityManager->createQuery(
            'SELECT ngs FROM '
            .'AsistentPlusPlus\Entity\NajavljenaGrupaSala ngs '
            .'JOIN AsistentPlusPlus\Entity\Sala s '
            .'WHERE ngs.sala = s.id AND s.oznaka = :oznakaSale');

        $query->setParameter('oznakaSale',$oznakaSale);

        return $query->getResult();
    }

    public function pronadjiPoRbrNajave($rbrNajave){
        $query = $this->entityManager->createQuery(
            'SELECT ngs FROM '
            .'AsistentPlusPlus\Entity\NajavljenaGrupaSala ngs '
            .'JOIN AsistentPlusPlus\Entity\NajavljenaGrupa ng '
            .'WHERE ngs.rbrNajave = ng.rbrNajave AND ngs.rbrNajave = :rbrNajave');

        $query->setParameter('rbrNajave',$rbrNajave);

        return $query->getResult();
    }

    public function unesi(NajavljenaGrupaSala $najavljenaGrupaSalaEntity)
    {
        $this->entityManager->persist($najavljenaGrupaSalaEntity);
        $this->entityManager->flush();
    }
}