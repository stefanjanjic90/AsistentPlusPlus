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

    public function pronadjiSveAktivnePoRbrZakazivanja($rbrZakazivanja){
        $query = $this->entityManager->createQuery(
            ' SELECT zg FROM '
            .' AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .' WHERE zg.rbrZakazivanja := rbrZakazivanja and zg.status = false');

        $query->setParameter('rbrZakazivanja',$rbrZakazivanja);

        return $query->getResult();
    }

    public function pronadjiSveAktivnePoObavezi($obavezaId){
        $query = $this->entityManager->createQuery(
            ' SELECT zg FROM '
            .' AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .' JOIN AsistentPlusPlus\Entity\Obaveza o '
            .' WHERE zg.obaveza = o.id AND o.id = :obavezaId and zg.status = false');

        $query->setParameter('obavezaId',$obavezaId);

        return $query->getResult();
    }

    public function pronadjiZavrsenePoKorisnickomImenu($korisnickoIme){
        $query = $this->entityManager->createQuery('SELECT zg FROM '
            .' AsistentPlusPlus\Entity\ZakazanaGrupaDezurni zgd '
            .' JOIN AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .' WHERE zgd.rbrZakazivanja = zg.rbrZakazivanja '
            .' AND zgd.korisnickoIme=:korisnickoIme '
            .' AND zg.status = true');
        $query->setParameter('korisnickoIme',$korisnickoIme);
        return $query->getResult();
    }

    public function pronadjiSve(){
        return $this->repository->findAll();
    }

    public function pronadjiSveAktivne(){
        $query = $this->entityManager->createQuery('SELECT zg FROM '
            .' AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .' WHERE zg.status = false ');

        return $query->getResult();
    }

    public function unesi(ZakazanaGrupa $zakazanaGrupaEntity)
    {
        $this->entityManager->persist($zakazanaGrupaEntity);
        $this->entityManager->flush();
    }
} 