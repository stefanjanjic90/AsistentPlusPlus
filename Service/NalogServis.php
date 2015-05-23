<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\Nalog;

class NalogServis {

    private $entityManager;

    private $repository;

    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
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

    public function dodajKorisnika(Nalog $nalogEntity)
    {
        $this->entityManager->persist($nalogEntity);
        $this->entityManager->flush();
    }

    public function azurirajKorisnika(Nalog $nalogEntity)
    {
        $this->entityManager->merge($nalogEntity);
        $this->entityManager->flush();
    }
} 