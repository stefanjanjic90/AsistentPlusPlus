<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\PonudjeneZamene;

class PonudjeneZameneServis {


    private $entityManager;
    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\PonudjeneZamene');
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiPoKorisnickomImenu($korisnickoIme){
        $query = $this->entityManager->createQuery(
                        'SELECT pz FROM '
                        .'AsistentPlusPlus\Entity\PonudjeneZamene pz '
                        .'JOIN AsistentPlusPlus\Entity\Nalog n '
                        .'WHERE pz.korisnickoImePrimaoca = n.korisnickoIme AND n.korisnickoIme = :korisnickoIme');

        $query->setParameter('korisnickoIme',$korisnickoIme);

        return $query->getResult();
    }

    public function unesi(PonudjeneZamene $ponudjeneZameneEntity)
    {
        $this->entityManager->persist($ponudjeneZameneEntity);
        $this->entityManager->flush();
    }
}