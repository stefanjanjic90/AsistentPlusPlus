<?php

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Service\SalaServis;

class SalaKontroler {

    private $salaServis;

    function __construct()
    {
        $this->salaServis = new SalaServis();
    }

    public function vratiSveSale()
    {
        $sale=array();

        foreach ($this->salaServis->pronadjiSveSale() as $sala)
        {
            $jsonObject=new \stdClass();

            $jsonObject->id=$sala->getId();
            $jsonObject->ime=$sala->getOznaka();
            $jsonObject->kapacitet=$sala->getKapacitet();
            $jsonObject->racunari=$sala->getRacunariKapacitet();

            array_push($sale, $jsonObject);
        }

        header('Content-Type: application/json');
        echo json_encode($sale, JSON_PRETTY_PRINT);

    }
} 