<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 3/12/2015
 * Time: 9:14 PM
 */

namespace AsistentPlusPlus\Controller;

use AsistentPlusPlus\Service\NalogServis;

class KorisniciKontroler {

    private $nalogServis;

    function __construct()
    {
        $this->nalogServis = new NalogServis();
    }

    public function vratiSveKorisnike()
    {
        $korisnici=array();

        foreach ($this->nalogServis->pronadjiSveKorisnike() as $korisnik)
        {
            $jsonObject=new \stdClass();

            $jsonObject->imeprezime=$korisnik->getIme()." ".$korisnik->getPrezime();

            if($korisnik->getStatus())
                $jsonObject->status="aktivan";
            else
                $jsonObject->status="neaktivan";

            array_push($korisnici, $jsonObject);
        }

        $json = json_encode($korisnici, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        echo $json;

    }
} 