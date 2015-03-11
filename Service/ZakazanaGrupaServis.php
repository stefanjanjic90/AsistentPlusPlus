<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 3/10/2015
 * Time: 8:57 PM
 */

namespace AsistentPlusPlus\Service;


use AsistentPlusPlus\Entity\ZakazanaGrupa;

class ZakazanaGrupaServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupa');
    }

    public function pronadjiPoRbrZakazivanja($rbrZakazivanja){
        return $this->repository->find($rbrZakazivanja);
    }

    public function pronadjiSvePoObavezi($obavezaId){
        $query = $this->entityManager->createQuery(
            'SELECT zg FROM'
            .'AsistentPlusPlus\Entity\ZakazanaGrupa zg'
            .'JOIN AsistentPlusPlus\Entity\Obaveza o '
            .'WHERE zg.obaveza = o.id AND o.id = :obavezaId');

        $query->setParameter('obavezaId',$obavezaId);

        return $query->getResult();
    }

    public function unesi(ZakazanaGrupa $zakazanaGrupaEntity)
    {
        $this->entityManager->persist($zakazanaGrupaEntity);
        $this->entityManager->flush();
    }
} 