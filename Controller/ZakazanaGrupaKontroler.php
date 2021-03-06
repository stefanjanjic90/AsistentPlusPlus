<?php
namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Service\ZakazanaGrupaDezurniServis;
use AsistentPlusPlus\Service\ZakazanaGrupaServis;
use AsistentPlusPlus\Service\NalogServis;
use Doctrine\Common\Collections\ArrayCollection;

class ZakazanaGrupaKontroler {

    private $zakazanaGrupaServis;
    private $zakazanaGrupaDezurniServis;
    private $nalogServis;

    function __construct()
    {
        $this->zakazanaGrupaServis=new ZakazanaGrupaServis();
        $this->zakazanaGrupaDezurniServis=new ZakazanaGrupaDezurniServis();
        $this->nalogServis = new NalogServis();
    }

    public function vratiZakazaneGrupe($parametri)
    {
        $datum = $parametri[0][1];

        $objectArray = [];

        foreach ($this->zakazanaGrupaServis->pronadjiSveOdDatumaNaDalje($datum) as $zakazanaGrupa)
        {
            $jsonObject = new \stdClass();

            $jsonObject->id = $zakazanaGrupa->getRbrZakazivanja();
            $jsonObject->datum = $zakazanaGrupa->getDatum()->format('d-m-Y');
            $jsonObject->vreme = $zakazanaGrupa->getPocetakRezervacije()->format('H:i');

            $saleNiz=array();

            foreach ($zakazanaGrupa->getZakazaneGrupeSala() as $zakazanaGrupaSala)
                array_push($saleNiz,$zakazanaGrupaSala->getSala()->getOznaka());

            $saleString=join(", ",$saleNiz);

            $jsonObject->ucionice = $saleString;
            $jsonObject->opis = $zakazanaGrupa->getObaveza()->getNazivObaveze();


            $nalog=$this->nalogServis->pronadjiPoKorisnickomImenu($zakazanaGrupa->getObaveza()->getKorisnickoImeGlavnogDezurnog());

            $jsonObject->glavni_dezurni = $nalog->getIme()." ".$nalog->getPrezime();

            $objectArray [] = $jsonObject;

        }

        header('Content-Type: application/json');
        echo json_encode($objectArray, JSON_PRETTY_PRINT);

    }

    public function vratiNapomeneZaAsistenta($parametri)
    {
        $korisnickoIme = $parametri[0][1];

        $napomeneArray = array();

        foreach($this->zakazanaGrupaDezurniServis->pronadjiNapomenePoKorisnickomImenu($korisnickoIme) as $napomena)
        {
            $napomenaObject = new \stdClass();
            $napomenaObject->assistant=$napomena->getKorisnickoImeGlavnogDezurnog();

            $napomenaObject->id_duty=$napomena->getZakazanaGrupaDezurniId()->getRbrZakazivanja()->getObaveza()->getId();

            $napomenaObject->comment=$napomena->getNapomena();
            $napomenaObject->course=$napomena->getZakazanaGrupaDezurniId()->getRbrZakazivanja()->getObaveza()->getNazivObaveze();
            $napomenaObject->date=$napomena->getZakazanaGrupaDezurniId()->getRbrZakazivanja()->getDatum()->format("d.m.Y");

            $napomeneArray[] = $napomenaObject;
        }

        header('Content-Type: application/json');
        echo json_encode($napomeneArray, JSON_PRETTY_PRINT);
    }
} 