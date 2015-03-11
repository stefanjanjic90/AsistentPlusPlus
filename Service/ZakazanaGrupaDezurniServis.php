<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 3/10/2015
 * Time: 8:57 PM
 */

namespace AsistentPlusPlus\Service;


use AsistentPlusPlus\Entity\ZakazanaGrupaDezurni;

class ZakazanaGrupaDezurniServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\ZakazanaGrupaDezurni');
    }

    public  function  pronadjiPoId($id)
    {
        return $this->repository->find($id);
    }
    public function pronadjiPoRbrZakazivanja($rbrZakazivanja){
        $query = $this->entityManager->createQuery('SELECT zgd FROM'
            .' AsistentPlusPlus\Entity\ZakazanaGrupaDezurni zgd'
            .' WHERE zgd.rbrZakazivanja=:rbrZakazivanja');
        $query->setParameter('rbrZakazivanja',$rbrZakazivanja);
        return $query->getResult();

    }

    public function pronadjiPoKorisnickomImenu($korisnickoIme){
        $query = $this->entityManager->createQuery('SELECT zgd FROM'
            .' AsistentPlusPlus\Entity\ZakazanaGrupaDezurni zgd'
            .' WHERE zgd.korisnickoIme=:korisnickoIme');
        $query->setParameter('korisnickoIme',$korisnickoIme);
        return $query->getResult();
    }

    public function unesi(ZakazanaGrupaDezurni $zakazanaGrupaDezurniEntity)
    {
        $this->entityManager->persist($zakazanaGrupaDezurniEntity);
        $this->entityManager->flush();
    }
} 