<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi;

class PredmetniAsistentiNaObaveziServis
{

    private $entityManager;
    private $repository;

    public function __construct()
    {
        require_once __DIR__ . '\..\src\bootstrap.php';
        $this->entityManager = \Bootstrap::getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi');
    }

    public function pronadjiPoId($id)
    {
        return $this->repository->find($id);
    }

    public function pronadjiPoKorisnickomImenu($korisnickoIme)
    {
        $query = $this->entityManager->createQuery('SELECT pa FROM'
            . ' AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi pa'
            . ' WHERE pa.korisnickoIme=:korisnickoIme');
        $query->setParameter('korisnickoIme', $korisnickoIme);
        return $query->getResult();
    }

    public function unesi(PredmetniAsistentiNaObavezi $predmetniAsistentiNaObaveziEntity)
    {
        $this->entityManager->persist($predmetniAsistentiNaObaveziEntity);
        $this->entityManager->flush();
    }

    public function pronadjiPoIdObaveze($obavezaId)
    {
        $query = $this->entityManager->createQuery('SELECT pa FROM'
            . ' AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi pa'
            . ' WHERE pa.obaveza=:obavezaId');
        $query->setParameter('obavezaId', $obavezaId);
        return $query->getResult();
    }

    public function obrisi(PredmetniAsistentiNaObavezi $predmetniAsistentiNaObaveziEntity){
        $this->entityManager->remove($predmetniAsistentiNaObaveziEntity);
        $this->entityManager->flush();
    }
} 