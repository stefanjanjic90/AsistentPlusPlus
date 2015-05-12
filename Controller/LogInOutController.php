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
        if($this->verifyUser()){
            $_SESSION["Username"] = $_POST['inputUN'];
            $_SESSION["LoggedIn"] = 'true';

            $nalogEntity = $this->nalogServis->pronadjiPoKorisnickomImenu($_POST['inputUN']);

            $genericObject -> username = $nalogEntity->getKorisnickoIme();
            $genericObject -> administrator = $nalogEntity->getJeAdministrator();
            $genericObject -> koordinator = $nalogEntity->getJeKoordinator();
            $genericObject -> asistent = $nalogEntity->getJeDezurni();
            $genericObject -> logedin = true;

            $userJson = json_encode($genericObject);
            echo $userJson;

            echo'<br><br> logedIn <br>';
            echo '<br><form action="logout" method="post"> <button type="submit">logOut</button> </form><br>';
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

    private function verifyUser(){
        return $this->nalogServis->autentifikacijaKorisnika($_POST['inputUN'],$_POST['inputP']);
    }

}