<?php

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Entity\Nalog;
use AsistentPlusPlus\Service\KatedreServis;
use AsistentPlusPlus\Service\NalogServis;

class KorisniciKontroler
{

    private $nalogServis;
    private $katedraServis;

    function __construct()
    {
        $this->nalogServis = new NalogServis();
        $this->katedraServis = new KatedreServis();
    }

    public function vratiSveKorisnike()
    {
        $korisnici = array();

        foreach ($this->nalogServis->pronadjiSveKorisnike() as $korisnik) {
            $jsonObject = new \stdClass();
            $jsonObject->korisnickoIme = $korisnik->getKorisnickoIme();
            $jsonObject->imeprezime = $korisnik->getIme() . " " . $korisnik->getPrezime();

            if ($korisnik->getStatus())
                $jsonObject->status = "aktivan";
            else
                $jsonObject->status = "neaktivan";

            array_push($korisnici, $jsonObject);
        }

        $json = json_encode($korisnici, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        echo $json;

    }

    public function dodajNovogKorisnika()
    {
        $noviKorisnikPodaci = $_POST['noviKorisnik'];
        $requiredFields = ["korisnickoIme", "imePrezime", "email", "telefon", "sifra", "sifraPotvrda",
            "kat", "status", "koeficijent", "dezurniAsistent", "administrator", "koordinator", "napomena"];
        $fieldsNotSet = [];
        foreach ($requiredFields as $field) {
            if (!isset($noviKorisnikPodaci[$field])) {
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
        } elseif ($noviKorisnikPodaci["sifra"] !== $noviKorisnikPodaci["sifraPotvrda"]){
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Šifra nije ispravna.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        } elseif (!empty($this->nalogServis->pronadjiPoKorisnickomImenu($noviKorisnikPodaci["korisnickoIme"]))) {
            $responseObject = new \stdClass();
            $responseObject->status = "error";
            $responseObject->message = "Korisničko ime je već u upotrebi.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        } else {
            $noviNalog = new Nalog();

            $noviNalog->setKorisnickoIme($noviKorisnikPodaci["korisnickoIme"]);
            $imeIPrezime = $arr = explode(' ', trim($noviKorisnikPodaci["imePrezime"]));
            $noviNalog->setIme($imeIPrezime[0]);
            $noviNalog->setPrezime($imeIPrezime[1]);
            $noviNalog->setEmail($noviKorisnikPodaci["email"]);
            $noviNalog->setTelefon($noviKorisnikPodaci["telefon"]);
            $noviNalog->setLozinka($noviKorisnikPodaci["sifra"]);
            $noviNalog->setJeDezurni($noviKorisnikPodaci["dezurniAsistent"]);
            $noviNalog->setJeAdministrator($noviKorisnikPodaci["administrator"]);
            $noviNalog->setJeKoordinator($noviKorisnikPodaci["koordinator"]);
            $katedra = $this->katedraServis->pronadjiPoId($noviKorisnikPodaci["kat"]);
            $katedra->getNalozi()->add($noviNalog);
            $noviNalog->setKatedra($katedra);
            if ($noviKorisnikPodaci["status"] === "aktivan") {
                $noviNalog->setStatus(true);
            } else {
                $noviNalog->setStatus(false);
            }
            $noviNalog->setOpterecenje(0);
            $noviNalog->setKoeficijentAngazovanja($noviKorisnikPodaci["koeficijent"]);
            $noviNalog->setNapomena($noviKorisnikPodaci["napomena"]);

            $this->nalogServis->dodajKorisnika($noviNalog);

            $responseObject = new \stdClass();
            $responseObject->status = "success";
            $responseObject->message = "Uspešno unet novi korisnik.";
            header('Content-Type: application/json');
            echo json_encode($responseObject, JSON_PRETTY_PRINT);
        }
    }
}