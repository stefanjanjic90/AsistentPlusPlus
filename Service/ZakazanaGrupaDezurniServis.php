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

    public function pronadjiAktivnePoKorisnickomImenu($korisnickoIme){
        $query = $this->entityManager->createQuery('SELECT zgd FROM '
            .' AsistentPlusPlus\Entity\ZakazanaGrupaDezurni zgd '
            .' JOIN AsistentPlusPlus\Entity\ZakazanaGrupa zg '
            .' WHERE zgd.rbrZakazivanja = zg.rbrZakazivanja '
            .' AND zgd.korisnickoIme=:korisnickoIme '
            .' AND zg.status = false');
        $query->setParameter('korisnickoIme',$korisnickoIme);
        return $query->getResult();
    }

    public function pronadjiSveSlobodneAsistente($datum, $vreme){

        $notInZauzet = $this->entityManager->createQueryBuilder()
            ->select('IDENTITY(zgd.korisnickoIme)')
            ->from('AsistentPlusPlus\Entity\ZakazanaGrupa ','zg')
            ->join('AsistentPlusPlus\Entity\ZakazanaGrupaDezurni','zgd')
            ->where('zg.rbrZakazivanja=zgd.rbrZakazivanja')
            ->where('zg.datum=:datum')
            ->andWhere('zg.pocetakRezervacije!=:vreme OR zg.krajRezervacije!=:vreme')
            ->andWhere(':vreme NOT BETWEEN zg.pocetakRezervacije AND zg.krajRezervacije')
            ->getDQL();

        $query = $this->entityManager->createQueryBuilder();
        $query->select('n')
            ->from('AsistentPlusPlus\Entity\Nalog','n')
            ->where($query->expr()->notIn('n.korisnickoIme',$notInZauzet));

        $query->setParameter('datum',$datum);
        $query->setParameter('vreme',$vreme);

        return $query->getQuery()->getResult();
    }



    public function unesi(ZakazanaGrupaDezurni $zakazanaGrupaDezurniEntity)
    {
        $this->entityManager->persist($zakazanaGrupaDezurniEntity);
        $this->entityManager->flush();
    }
} 