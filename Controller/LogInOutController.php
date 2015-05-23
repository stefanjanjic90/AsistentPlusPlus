<?php
namespace AsistentPlusPlus\Controller;
require_once __DIR__.'\..\vendor\autoload.php';
use AsistentPlusPlus\Service\NalogServis;

class LogInOutController {

    private $nalogServis;

    public function __construct(){
        $this->nalogServis = new NalogServis();
    }

    public function logIn(){
        $genericObject = new \stdClass();
        if($this->verifyUser($_POST['loginData']['username'], $_POST['loginData']['password'])){
            $_SESSION["Username"] = $_POST['loginData']['username'];
            $_SESSION["LoggedIn"] = $_POST['loginData']['password'];

            $nalogEntity = $this->nalogServis->pronadjiPoKorisnickomImenu($_SESSION["Username"]);

            $genericObject -> username = $nalogEntity->getKorisnickoIme();
            $genericObject ->ime_prezime = $nalogEntity->getIme() . " " . $nalogEntity->getPrezime();
            $genericObject -> administrator = $nalogEntity->getJeAdministrator();
            $genericObject -> koordinator = $nalogEntity->getJeKoordinator();
            $genericObject -> asistent = $nalogEntity->getJeDezurni();
            $genericObject -> logedin = true;

            header('Content-Type: application/json');
            $userJson = json_encode($genericObject);
            echo $userJson;
        }else{
            $genericObject -> username = "";
            $genericObject -> administrator = false;
            $genericObject -> koordinator = false;
            $genericObject -> asistent = false;
            $genericObject -> logedin = false;

            $userJson = json_encode($genericObject);
            echo $userJson;
        }

    }

    public function logOut(){
        session_unset();
        session_destroy();

        $genericObject = new \stdClass();
        $genericObject -> username = "";
        $genericObject -> administrator = false;
        $genericObject -> koordinator = false;
        $genericObject -> asistent = false;
        $genericObject -> logedin = false;

        $userJson = json_encode($genericObject);
        echo $userJson;
    }

    public function notLoggedIn(){
        $genericObject = new \stdClass();
        $genericObject -> username = "";
        $genericObject -> administrator = false;
        $genericObject -> koordinator = false;
        $genericObject -> asistent = false;
        $genericObject -> logedin = false;

        $userJson = json_encode($genericObject);
        echo $userJson;
    }

    private function verifyUser($username,$password){
        return $this->nalogServis->autentifikacijaKorisnika($username,$password);
    }

}