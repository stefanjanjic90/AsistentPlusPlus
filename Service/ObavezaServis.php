<?php

namespace AsistentPlusPlus\Service;

use AsistentPlusPlus\Entity\Obaveza;

class ObavezaServis {

    private $entityManager;
    private $repository;
    public function __construct(){
        require_once __DIR__.'\..\src\bootstrap.php';
        $this->entityManager = getEntityManager();
        $this->repository = $this->entityManager->getRepository('AsistentPlusPlus\Entity\Obaveza');
    }

    public function pronadjiSve(){
        return $this->repository->findAll();
    }

    public function pronadjiPoId($id){
        return $this->repository->find($id);
    }

    public function pronadjiPoNazivu($naziv){
        $query = $this->entityManager->createQuery('SELECT o FROM AsistentPlusPlus\Entity\Obaveza o WHERE o.nazivObaveze=:naziv');
        $query->setParameter('naziv',$naziv);
        return $query->getResult();
    }

    public function pronadjiPoKorisnickomImenuGlavnogDezurnog($korisnickoIme){
        $query = $this->entityManager->createQuery('SELECT o FROM AsistentPlusPlus\Entity\Obaveza o WHERE o.korisnickoImeGlavnogDezurnog=:korisnickoIme');
        $query->setParameter('korisnickoIme',$korisnickoIme);
        return $query->getResult();
    }

    public function pronadjiSveZavrseneObavezePoKorisnickomImenu($korisnickoIme){

        $notInAktivne = $this->entityManager->createQueryBuilder()
            ->select('IDENTITY(zg.obaveza)')
            ->from('AsistentPlusPlus\Entity\ZakazanaGrupa ','zg')
            ->where('zg.status=FALSE')->getDQL();

        $notInNeaktivne = $this->entityManager->createQueryBuilder()
            ->select('IDENTITY(zg2.obaveza)')
            ->from('AsistentPlusPlus\Entity\ZakazanaGrupa ','zg2')
            ->where('zg2.status=TRUE')->getDQL();

        $query = $this->entityManager->createQueryBuilder();
        $query->select('o')
            ->from('AsistentPlusPlus\Entity\Obaveza','o')
            ->join('AsistentPlusPlus\Entity\PredmetniAsistentiNaObavezi', 'pao')
            ->where('o.id=pao.obaveza')
            ->andWhere('pao.korisnickoIme = :korisnickoIme')
            ->andWhere($query->expr()->notIn('o.id',$notInAktivne))
            ->andWhere($query->expr()->in('o.id',$notInNeaktivne))
            ->setParameter('korisnickoIme', $korisnickoIme);

        return $query->getQuery()->getResult();
    }

    public function unesi(Obaveza $obavezaEntity)
    {
        $this->entityManager->persist($obavezaEntity);
        $this->entityManager->flush();
    }
} 