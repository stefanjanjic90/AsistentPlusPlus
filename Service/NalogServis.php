<?php

namespace AsistentPlusPlus\Service;

class NalogServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Nalog');
    }

    public function pronadjiPoKorisnickomImenu($korisnickoIme){
        return $this->repository->find($korisnickoIme);
    }

    public function autentifikacijaKorisnika($korisnickoIme,$lozinka){

        $korisnik = $this->repository->find($korisnickoIme);

        if($korisnik !== null && $korisnik->getLozinka() === $lozinka){
            return true;
        }
        else{
            return false;
        }
    }

    public function pronadjiSveKorisnike(){
        return $this->repository->findAll();
    }
} 