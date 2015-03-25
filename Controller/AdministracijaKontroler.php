<?php

namespace AsistentPlusPlus\Controller;
require_once __DIR__.'\..\vendor\autoload.php';

class AdministracijaKontroler {

    public function __construct(){
    }


    public function info(){

        $infoJsonFile = file_get_contents(__DIR__.'\..\config\adminInfo.json');

        if($infoJsonFile === false){
            $infoJsonFile = '';
        }
        $infoJsonObject = json_decode($infoJsonFile);
        header('Content-Type: application/json');
        echo json_encode($infoJsonObject, JSON_PRETTY_PRINT,512);
    }
}