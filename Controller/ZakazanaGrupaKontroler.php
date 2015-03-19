<?php
namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Service\ZakazanaGrupaServis;
use AsistentPlusPlus\Service\NalogServis;
use Doctrine\Common\Collections\ArrayCollection;

class ZakazanaGrupaKontroler {

    private $zakazanaGrupaServis;
    private $nalogServis;

    function __construct()
    {
        $this->zakazanaGrupaServis=new ZakazanaGrupaServis();
        $this->nalogServis = new NalogServis();
    }

    public function vratiZakazaneGrupe()
    {
        $jsonObject = new \stdClass();

        foreach ($this->zakazanaGrupaServis->pronadjiSveAktivne() as $zakazanaGrupa)
        {
            $jsonObject->id = $zakazanaGrupa->getRbrZakazivanja();
            $jsonObject->datum = $zakazanaGrupa->getDatum()->format('m-d-Y');
            $jsonObject->vreme = $zakazanaGrupa->getPocetakRezervacije()->format('H:i');

            $saleNiz=array();

            foreach ($zakazanaGrupa->getZakazaneGrupeSala() as $zakazanaGrupaSala)
                array_push($saleNiz,$zakazanaGrupaSala->getSala()->getOznaka());

            $saleString=join(", ",$saleNiz);

            $jsonObject->ucionice = $saleString;
            $jsonObject->opis = $zakazanaGrupa->getObaveza()->getNazivObaveze();


            $nalog=$this->nalogServis->pronadjiPoKorisnickomImenu($zakazanaGrupa->getObaveza()->getKorisnickoImeGlavnogDezurnog());

            $jsonObject->glavni_dezurni = $nalog->getIme()." ".$nalog->getPrezime();

        }

        header('Content-Type: application/json');
        echo json_encode($jsonObject, JSON_PRETTY_PRINT);

    }
} 