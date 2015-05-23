<?php

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Entity\Sala;
use AsistentPlusPlus\Service\LokacijaServis;
use AsistentPlusPlus\Service\SalaServis;

class SalaKontroler
{

    private $salaServis;
    private $lokacijaServis;

    function __construct()
    {
        $this->salaServis = new SalaServis();
        $this->lokacijaServis = new LokacijaServis();
    }

    public function vratiSveSale()
    {
        $sale = array();

        foreach ($this->salaServis->pronadjiSveSale() as $sala) {
            $jsonObject = new \stdClass();

            $jsonObject->id = $sala->getId();
            $jsonObject->ime = $sala->getOznaka();
            $jsonObject->kapacitet = $sala->getKapacitet();
            $jsonObject->racunari = $sala->getRacunariKapacitet();

            array_push($sale, $jsonObject);
        }

        header('Content-Type: application/json');
        echo json_encode($sale, JSON_PRETTY_PRINT);

    }

    public function unesiUcionicu()
    {
        $ucionica = $_POST['ucionica'];

        $requiredFields = ["ime", "kapacitet", "racunari", "lokacijaId"];
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
        } elseif (!is_numeric($ucionica["kapacitet"]) || !is_numeric($ucionica["racunari"]) || !is_numeric($ucionica["lokacijaId"])) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Polja nemaju adekvatnu vrednost";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }elseif (empty($this->lokacijaServis->pronadjiPoId($ucionica["lokacijaId"]))) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Lokacija ne postoji.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        } else {
            $novaSala = new Sala();

            $lokacija = $this->lokacijaServis->pronadjiPoId($ucionica["lokacijaId"]);
            $novaSala->setLokacija($lokacija);
            $novaSala->setOznaka($ucionica['ime']);
            $novaSala->setKapacitet($ucionica['kapacitet']);
            $novaSala->setRacunariKapacitet($ucionica['racunari']);

            $this->salaServis->unesiSalu($novaSala);

            $responseObject = new \stdClass();
            $responseObject->status = "success";
            $responseObject->message = "Uspešno uneta nova učionica";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }

    }

    public function azurirajUcionicu()
    {
        $ucionica = $_POST['ucionica'];

        $requiredFields = ["id","ime", "kapacitet", "racunari", "lokacijaId"];
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
        } elseif (!is_numeric($ucionica["id"])
            || !is_numeric($ucionica["kapacitet"])
            || !is_numeric($ucionica["racunari"])
            || !is_numeric($ucionica["lokacijaId"])) {

            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Polja nemaju adekvatnu vrednost";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }elseif (empty($this->lokacijaServis->pronadjiPoId($ucionica["lokacijaId"]))) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Lokacija ne postoji.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }elseif (empty($this->salaServis->pronadjiPoId($ucionica["id"]))) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Ucionica ne postoji.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        } else {
            $sala = $this->salaServis->pronadjiPoId($ucionica['id']);

            $lokacija = $this->lokacijaServis->pronadjiPoId($ucionica["lokacijaId"]);
            $sala->setLokacija($lokacija);
            $sala->setOznaka($ucionica['ime']);
            $sala->setKapacitet($ucionica['kapacitet']);
            $sala->setRacunariKapacitet($ucionica['racunari']);

            $this->salaServis->azurirajSalu($sala);

            $responseObject = new \stdClass();
            $responseObject->status = "success";
            $responseObject->message = "Uspešno ažurirana učionica";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }

    }
} 