<?php

namespace AsistentPlusPlus\Controller;
require_once __DIR__ . '\..\vendor\autoload.php';

class AdministracijaKontroler
{

    public function __construct(){}

    public function info()
    {

        $infoJsonFile = file_get_contents(__DIR__ . '\..\config\adminInfo.json');

        if ($infoJsonFile === false) {
            $infoJsonFile = '';
        }
        $infoJsonObject = json_decode($infoJsonFile);
        header('Content-Type: application/json');
        echo json_encode($infoJsonObject, JSON_PRETTY_PRINT, 512);
    }

    public function sacuvajInfo()
    {
        $postData = $_POST['info'];
        $responseObject = new \stdClass();
        try {
            $infoJsonFile = file_get_contents(__DIR__ . '\..\config\adminInfo.json');

            $fileData = json_decode($infoJsonFile);

            foreach ($postData as $key => $value) {

                $fileData->$key = $postData[$key];
            }

            file_put_contents(__DIR__ . '\..\config\adminInfo.json', json_encode($fileData));

            $responseObject->status = 'success';
            $responseObject->message= 'Uspešnа izmena.';

        }catch (\Exception $e){
            $responseObject->status = 'error';
            $responseObject->message= 'Izmena podataka nije uspešna.';
            $responseObject->exception = $e;
        }

        header('Content-Type: application/json');
        echo json_encode($responseObject, JSON_PRETTY_PRINT, 512);
    }
}