<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\ZakazanaGrupaSala;

class ZakazanaGrupaSalaServis {


    private $entityManager;
    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupaSala');
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiSvePoIdSale($salaId){
        $query = $this->entityManager->createQuery(
            'SELECT zgs FROM '
            .'AsistentPlusPlus\Entity\ZakazanaGrupaSala zgs '
            .'JOIN AsistentPlusPlus\Entity\Sala s '
            .'WHERE zgs.sala = s.id AND s.id = :salaId');

        $query->setParameter('salaId',$salaId);

        return $query->getResult();
    }

    public function pronadjiSvePoOznaciSale($oznakaSale){
        $query = $this->entityManager->createQuery(
            'SELECT zgs FROM '
            .'AsistentPlusPlus\Entity\ZakazanaGrupaSala zgs '
            .'JOIN AsistentPlusPlus\Entity\Sala s '
            .'WHERE zgs.sala = s.id AND s.oznaka = :oznakaSale');

        $query->setParameter('oznakaSale',$oznakaSale);

        return $query->getResult();
    }

    public function pronadjiPoRbrZakazivanja($rbrZakazivanja){
        $query = $this->entityManager->createQuery(
            'SELECT zgs FROM '
            .'AsistentPlusPlus\Entity\ZakazanaGrupaSala zgs '
            .'JOIN AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .'WHERE zgs.rbrZakazivanja = zg.rbrZakazivanja AND zgs.rbrZakazivanja = :rbrZakazivanja');

        $query->setParameter('rbrZakazivanja',$rbrZakazivanja);

        return $query->getResult();
    }

    public function unesi(ZakazanaGrupaSala $zakazanaGrupaSalaEntity)
    {
        $this->entityManager->persist($zakazanaGrupaSalaEntity);
        $this->entityManager->flush();
    }
}