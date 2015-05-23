<?php

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Entity\Sala;
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

    public function unesiUcionicu()
    {
        $ucionica = $_POST['ucionica'];

        $requiredFields = ["ime", "kapacitet", "racunari"];
        $fieldsNotSet = [];
        foreach ($requiredFields as $field) {
            if (!isset($ucionica[$field])) {
                $fieldsNotSet[] = $field;
            }
        }
        if (!empty($fieldsNotSet)) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Nisu sva polja popunjena.";
            $responseObject->requiredFields = $fieldsNotSet;
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }elseif(!is_numeric($ucionica["kapacitet"]) || !is_numeric($ucionica["racunari"])){
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Polja nemaju adekvatnu vrednost";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }else{
            $novaSala = new Sala();
            $novaSala->setOznaka($ucionica['ime']);
            $novaSala->setKapacitet($ucionica['kapacitet']);
            $novaSala->setRacunariKapacitet($ucionica['racunari']);

        }

        header('Content-Type: application/json');
        echo json_encode($sale, JSON_PRETTY_PRINT);

    }
} 