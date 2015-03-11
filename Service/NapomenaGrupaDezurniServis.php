<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 3/10/2015
 * Time: 8:57 PM
 */

namespace AsistentPlusPlus\Service;


use AsistentPlusPlus\Entity\NapomenaGrupaDezurni;

class NapomenaGrupaDezurniServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\NapomenaGrupaDezurni');
    }

    public  function  pronadjiPoId($id)
    {
        return $this->repository->find($id);
    }

    public function pronadjiPoKorisnickomImenu($korisnickoIme){
        $query = $this->entityManager->createQuery('SELECT ngd FROM'
            .' AsistentPlusPlus\Entity\NapomenaGrupaDezurni ngd'
            .' WHERE ngd.korisnickoImeGlavnogDezurnog=:korisnickoIme');
        $query->setParameter('korisnickoIme',$korisnickoIme);
        return $query->getResult();
    }

    public function pronadjiPoDatumu($datum)
    {
        $query = $this->entityManager->createQuery('SELECT ngd FROM'
            .' AsistentPlusPlus\Entity\NapomenaGrupaDezurni ngd'
            .' WHERE ngd.datumNapomene=:datum');
        $query->setParameter('datum',$datum);
        return $query->getResult();
    }

    public function unesi(NapomenaGrupaDezurni $napomenaGrupaDezurniEntity)
    {
        $this->entityManager->persist($napomenaGrupaDezurniEntity);
        $this->entityManager->flush();
    }
} 