<?php

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Service\KatedreServis;

class KatedraKontroler {

    private $katedraServis;

    function __construct()
    {
        $this->katedraServis = new KatedreServis();
    }

    public function vratiSveKatedre()
    {
        $katedre=array();

        foreach ($this->katedraServis->pronadjiSveKatedre() as $katedra)
            array_push($katedre, $katedra->getNaziv());

        header('Content-Type: application/json');
        echo json_encode($katedre, JSON_PRETTY_PRINT);

    }
} 