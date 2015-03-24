<?php
namespace AsistentPlusPlus\Controller;

require_once __DIR__.'\..\vendor\autoload.php';
use AsistentPlusPlus\Service\NalogServis;
use AsistentPlusPlus\Service\ObavezaServis;
use AsistentPlusPlus\Service\ZakazanaGrupaDezurniServis;
use AsistentPlusPlus\Service\ZakazanaGrupaServis;

class DezurstvaKontroler {

    private $obavezaServis;
    private $zakazanaGrupaServis;
    private $zakazanaGrupaDezurniServis;
    private $nalogServis;

    public function __construct(){
        $this->obavezaServis = new ObavezaServis();
        $this->zakazanaGrupaServis = new ZakazanaGrupaServis();
        $this->zakazanaGrupaDezurniServis = new ZakazanaGrupaDezurniServis();
        $this->nalogServis = new NalogServis();
    }

    public function glavnaDezurstva($parametri){

        $korisnickoIme = $parametri[0][1];

        $obavezeGlavnogDezurnog = $this->obavezaServis->pronadjiPoKorisnickomImenuGlavnogDezurnog($korisnickoIme);
        $glavnaDezurstva = array();

        foreach($obavezeGlavnogDezurnog as $obavezaGlavnogDezurnog){

            $dezurstvoObject = new \stdClass();

            $dezurstvoObject->id = $obavezaGlavnogDezurnog->getId();
            $dezurstvoObject->course = $obavezaGlavnogDezurnog->getNazivObaveze();

            // TODO
            //$dezurstvoObject->date = $obavezaGlavnogDezurnog->getDatum();

            //$dezurstvoObject->remark = $obavezaGlavnogDezurnog->getNapomenaZaDezurne();

            $timeSumValues = array();

            // groups
            $dezurstvoObject->groups = array();
            $zakazaneGrupeNaObavezi = $this->zakazanaGrupaServis->pronadjiSveAktivnePoObavezi($obavezaGlavnogDezurnog->getId());
            foreach($zakazaneGrupeNaObavezi as $zakazanaGrupa){
                $zakazanaGrupaObject = new \stdClass();

                $zakazanaGrupaObject->name = $zakazanaGrupa->getGrupa();
                $zakazanaGrupaObject->start = $zakazanaGrupa->getPocetakRezervacije()->format('H:i');
                $zakazanaGrupaObject->end = $zakazanaGrupa->getKrajRezervacije()->format('H:i');
                $zakazanaGrupaObject->numOfStudents = $zakazanaGrupa->getBrojPrijavljenih();

                // save start and end time for later calculation of timeSum field
                $timeSumValues[] = $zakazanaGrupa->getPocetakRezervacije();
                $timeSumValues[] = $zakazanaGrupa->getKrajRezervacije();

                // assistants
                $asistentiNaObavezi = $zakazanaGrupa->getZakazaneGrupeDezurni();
                $zakazanaGrupaObject->assistants=array();
                foreach($asistentiNaObavezi as $asistentNaObavezi){
                    $zakazanaGrupaObject->assistants[] = $asistentNaObavezi->getKorisnickoIme()->getIme(). " " .$asistentNaObavezi->getKorisnickoIme()->getPrezime();
                }

                //classrooms
                $zakazanaGrupaSale = $zakazanaGrupa->getZakazaneGrupeSala();
                $zakazanaGrupaObject->classrooms = array();
                foreach($zakazanaGrupaSale as $zakazanaGrupaSala){
                    $zakazanaGrupaObject->classrooms[]=$zakazanaGrupaSala->getSala()->getOznaka();
                }

                $dezurstvoObject->groups[] = $zakazanaGrupaObject;
            }

            //timeSum
            sort($timeSumValues);
            reset($timeSumValues);
            $od = current($timeSumValues);
            end($timeSumValues);
            $do = current($timeSumValues);
            $dezurstvoObject->timeSum = $od->format("H:i") ."-". $do->format("H:i");


            $glavnaDezurstva[] = $dezurstvoObject;
        }
        header('Content-Type: application/json');
        echo json_encode($glavnaDezurstva, JSON_PRETTY_PRINT,512);
    }

    public function sporednaDezurstva($parametri){
        $korisnickoIme = $parametri[0][1];

        $zakazaneGrupeDezurni = $this->zakazanaGrupaDezurniServis->pronadjiAktivnePoKorisnickomImenu($korisnickoIme);

        $sporednaDezurstva = array();

        foreach($zakazaneGrupeDezurni as $zakazanaGrupaDezurni){

            $dezurstvoObject = new \stdClass();

            $zakazanaGrupa = $zakazanaGrupaDezurni->getRbrZakazivanja();

            // course
            $dezurstvoObject->course = $zakazanaGrupa->getObaveza()-> getNazivObaveze();

            // assistant
            $nalogGlavnogDezurnog = $zakazanaGrupa->getObaveza()->getKorisnickoImeGlavnogDezurnog();
            $assistantVar = $nalogGlavnogDezurnog->getIme() ." ".$nalogGlavnogDezurnog->getPrezime();
            $dezurstvoObject->assistant = $assistantVar;

            // date
            $dezurstvoObject->date = $zakazanaGrupa->getDatum()-> format("d.m.Y");

            // time
            $dezurstvoObject->time = $zakazanaGrupa->getPocetakDezurstvaPomocnogDezurnog()-> format("H:i");

            // classroom
            $zakazanaGrupaSale = $zakazanaGrupa->getZakazaneGrupeSala();
            $classrooms = array();
            foreach($zakazanaGrupaSale as $zakazanaGrupaSala){
                $classrooms[] = $zakazanaGrupaSala->getSala()->getOznaka();
            }
            $dezurstvoObject->classrooms = $classrooms;

            //remark
            $dezurstvoObject->remark = $zakazanaGrupa->getNapomenaZaDezurne();

            // add to json array
            $sporednaDezurstva[] = $dezurstvoObject;
        }

        header('Content-Type: application/json');
        echo json_encode($sporednaDezurstva, JSON_PRETTY_PRINT);
    }



    public function satiNaDezurstvu($parametri)
    {
        $korisnickoIme = $parametri[0][1];

        $nalog=$this->nalogServis->pronadjiPoKorisnickomImenu($korisnickoIme);

        $jsonObject = new \stdClass();
        $jsonObject->assistant=$nalog->getIme()." ".$nalog->getPrezime();
        $jsonObject->time=$nalog->getOpterecenje()." sati";

        header('Content-Type: application/json');
        echo json_encode($jsonObject, JSON_PRETTY_PRINT);
    }

    public function ponudjeneZamene($parametri)
    {
        $korisnickoIme = $parametri[0][1];
        $rbrZakazivanja = $parametri[0][2];

        $nalog=$this->nalogServis->pronadjiPoKorisnickomImenu($korisnickoIme);
        $zakazanaGrupa=$this->zakazanaGrupaServis->pronadjiSveAktivnePoRbrZakazivanja($rbrZakazivanja);

        $dezurstvoOd=$zakazanaGrupa->getPocetakDezurstvaPomocnogDezurnog();
        $dezurstvoDo=new \DateTime($dezurstvoOd->format("H:i"));
        $dezurstvoDo=$dezurstvoDo->add(new \DateInterval('PT'.$zakazanaGrupa->getTrajanjeDezurstvaPomocnogDezurnog().'H'));

        $jsonObject = new \stdClass();
        $jsonObject->id_assistant=$nalog->getKorisnickoIme();
        $jsonObject->assistant=$nalog->getIme()." ".$nalog->getPrezime();
        $jsonObject->course=$zakazanaGrupa->getObaveza()->getNazivObaveze();
        $jsonObject->id_obaveze=$zakazanaGrupa->getObaveza()->getId();
        $jsonObject->date=$zakazanaGrupa->getDatum()->format("d.m.Y");
        $jsonObject->time=$dezurstvoOd->format("H:i")."-".$dezurstvoDo->format("H:i");

        header('Content-Type: application/json');
        echo json_encode($jsonObject, JSON_PRETTY_PRINT);
    }

    public function zavrsenaDezurstva($parametri)
    {
        $korisnickoIme = $parametri[0][1];

        $zavrseneZakazaneGrupe = $this->zakazanaGrupaServis->pronadjiZavrsenePoKorisnickomImenu($korisnickoIme);

        $zavrseneDezurstvaJson = array();
        foreach ($zavrseneZakazaneGrupe as $zavrsenaZakazanaGrupa){
            $zavrsenaZakazanaGrupaObject = new \stdClass();


            $zavrsenaZakazanaGrupaObject->course = $zavrsenaZakazanaGrupa->getObaveza()->getNazivObaveze();
            $zavrsenaZakazanaGrupaObject->date = $zavrsenaZakazanaGrupa->getDatum()->format('d.m.Y');

            if($zavrsenaZakazanaGrupa->getObaveza()->getKorisnickoImeGlavnogDezurnog() === $korisnickoIme){
                $zavrsenaZakazanaGrupaObject->duration = $zavrsenaZakazanaGrupa->getTrajanjeDezurstvaPredmetnogAsistenta() . "h";
            }else{
                $zavrsenaZakazanaGrupaObject->duration = $zavrsenaZakazanaGrupa->getTrajanjeDezurstvaPomocnogDezurnog() . "h";
            }

            $zavrseneDezurstvaJson [] = $zavrsenaZakazanaGrupaObject;
        }

        header('Content-Type: application/json');
        echo json_encode($zavrseneDezurstvaJson, JSON_PRETTY_PRINT);
    }

}