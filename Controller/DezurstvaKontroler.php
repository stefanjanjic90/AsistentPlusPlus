<?php
namespace AsistentPlusPlus\Controller;

require_once __DIR__ . '\..\vendor\autoload.php';
use AsistentPlusPlus\Service\NalogServis;
use AsistentPlusPlus\Service\ObavezaServis;
use AsistentPlusPlus\Service\ZakazanaGrupaDezurniServis;
use AsistentPlusPlus\Service\ZakazanaGrupaServis;

class DezurstvaKontroler
{

    private $obavezaServis;
    private $zakazanaGrupaServis;
    private $zakazanaGrupaDezurniServis;
    private $nalogServis;

    public function __construct()
    {
        $this->obavezaServis = new ObavezaServis();
        $this->zakazanaGrupaServis = new ZakazanaGrupaServis();
        $this->zakazanaGrupaDezurniServis = new ZakazanaGrupaDezurniServis();
        $this->nalogServis = new NalogServis();
    }
    // TODO MILICE PROVERI METODU
    public function glavnaDezurstva($parametri){

        $korisnickoIme = $parametri[0][1];

        $obavezeGlavnogDezurnog = $this->obavezaServis->pronadjiPoKorisnickomImenuGlavnogDezurnog($korisnickoIme);
        $glavnaDezurstva = array();

        foreach ($obavezeGlavnogDezurnog as $obavezaGlavnogDezurnog) {

            $dezurstvoObject = new \stdClass();

            $dezurstvoObject->id = $obavezaGlavnogDezurnog->getId();
            $dezurstvoObject->course = $obavezaGlavnogDezurnog->getNazivObaveze();

            //$timeSumValues = array();

            // groups
            $dezurstvoObject->groups = array();
            $zakazaneGrupeNaObavezi = $this->zakazanaGrupaServis->pronadjiSveAktivnePoObavezi($obavezaGlavnogDezurnog->getId());

            $trg = false;
            $jag = false;

            foreach($zakazaneGrupeNaObavezi as $zakazanaGrupa){
                $zakazanaGrupaObject = new \stdClass();

                $zakazanaGrupaObject->name = $zakazanaGrupa->getGrupa();
                $zakazanaGrupaObject->start = $zakazanaGrupa->getPocetakRezervacije()->format('H:i');
                $zakazanaGrupaObject->end = $zakazanaGrupa->getKrajRezervacije()->format('H:i');
                $zakazanaGrupaObject->numOfStudents = $zakazanaGrupa->getBrojPrijavljenih();

                // assistants
                $asistentiNaObavezi = $zakazanaGrupa->getZakazaneGrupeDezurni();
                $zakazanaGrupaObject->assistants=array();
                foreach($asistentiNaObavezi as $asistentNaObavezi){
                    //TODO id dezurnog ne postoji ne moze se prosledjivati
                    $zakazanaGrupaObject->assistants[] = $asistentNaObavezi->getKorisnickoIme()->getIme(). " " .$asistentNaObavezi->getKorisnickoIme()->getPrezime();
                }

                $zakazanaGrupaObject->numOfStudents = $zakazanaGrupa->getBrojPrijavljenih();

                $timeSumObject = new \stdClass();

                $zakazaneGrupePoDatumu=$this->zakazanaGrupaServis->pronadjiSveAktivnePoObaveziIDatumu($obavezaGlavnogDezurnog->getId(),$zakazanaGrupa->getDatum());

                foreach($zakazaneGrupePoDatumu as $zakazanaGrupaPoDatumu)
                {
                    // TODO koristi se za timeSum - dogovor
                    // save start and end time for later calculation of timeSum field
                    $timeSumValues[] = $zakazanaGrupaPoDatumu->getPocetakRezervacije();
                    $timeSumValues[] = $zakazanaGrupaPoDatumu->getKrajRezervacije();

                    //TODO ne radi dobro vracanje $do
                    //timeSum
                    sort($timeSumValues);
                    reset($timeSumValues);
                    $od = current($timeSumValues);
                    reset($timeSumValues);
                    end($timeSumValues);
                    $do = current($timeSumValues);
                    $timeSumObject->date = $zakazanaGrupa->getDatum()->format('d.m.Y');
                    $timeSumObject->sum = $od->format("H:i") ."-". $do->format("H:i");
                }


                //classrooms
                $zakazanaGrupaSale = $zakazanaGrupa->getZakazaneGrupeSala();
                $zakazanaGrupaObject->classrooms = array();



                foreach($zakazanaGrupaSale as $zakazanaGrupaSala) {
                    $zakazanaGrupaObject->classrooms[] = $zakazanaGrupaSala->getSala()->getOznaka();

                    //TODO srediti u dogovoru sa Tijanom
                    if (strpos($zakazanaGrupaSala->getSala()->getLokacija()->getSifra(), 'Trg') !== false) {
                        $trg = true;
                    }
                    if (strpos($zakazanaGrupaSala->getSala()->getLokacija()->getSifra(), 'Jag') !== false) {
                        $jag = true;
                    }
                }

                foreach ($zakazanaGrupaSale as $zakazanaGrupaSala) {
                    $zakazanaGrupaObject->classrooms[] = $zakazanaGrupaSala->getSala()->getOznaka();
                }

                // date
                $zakazanaGrupaObject->date = $zakazanaGrupa->getDatum()->format('d.m.Y');

                // remark
                $zakazanaGrupaObject->remark = $zakazanaGrupa->getNapomenaZaDezurne();

                $dezurstvoObject->groups[] = $zakazanaGrupaObject;


                $dezurstvoObject->useSRooms=$trg;

                $dezurstvoObject->useJagRooms=$jag;

                $dezurstvoObject->timeSum[]=$timeSumObject;
            }

            $glavnaDezurstva[] = $dezurstvoObject;
        }

        header('Content-Type: application/json');
        echo json_encode($glavnaDezurstva, JSON_PRETTY_PRINT, 512);
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
            foreach ($zakazanaGrupaSale as $zakazanaGrupaSala) {
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

        if ($korisnickoIme !== null) {
            $nalog = $this->nalogServis->pronadjiPoKorisnickomImenu($korisnickoIme);

            $jsonObject = new \stdClass();
            $jsonObject->id_assistant = $nalog->getKorisnickoIme();
            $jsonObject->name = $nalog->getIme() . " " . $nalog->getPrezime();
            $jsonObject->time = $nalog->getOpterecenje();

            header('Content-Type: application/json');
            echo json_encode($jsonObject, JSON_PRETTY_PRINT);
        } else {
            $nalogArray = $this->nalogServis->pronadjiSveKorisnike();

            $jsonObjectArray = array();

            foreach ($nalogArray as $nalog) {
                $jsonObject = new \stdClass();
                $jsonObject->id_assistant = $nalog->getKorisnickoIme();
                $jsonObject->name = $nalog->getIme() . " " . $nalog->getPrezime();
                $jsonObject->time = $nalog->getOpterecenje();

                $jsonObjectArray[] = $jsonObject;
            }

            header('Content-Type: application/json');
            echo json_encode($jsonObjectArray, JSON_PRETTY_PRINT);
        }

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

            if ($zavrsenaZakazanaGrupa->getObaveza()->getKorisnickoImeGlavnogDezurnog() === $korisnickoIme) {
                $zavrsenaZakazanaGrupaObject->duration = $zavrsenaZakazanaGrupa->getTrajanjeDezurstvaPredmetnogAsistenta() . "h";
            } else {
                $zavrsenaZakazanaGrupaObject->duration = $zavrsenaZakazanaGrupa->getTrajanjeDezurstvaPomocnogDezurnog() . "h";
            }

            $zavrseneDezurstvaJson [] = $zavrsenaZakazanaGrupaObject;
        }

        header('Content-Type: application/json');
        echo json_encode($zavrseneDezurstvaJson, JSON_PRETTY_PRINT);
    }

    public function moguceZamene($parametri)
    {
        $datum = $parametri[0][1];
        $vreme = $parametri[0][2];

        // TODO MILICA : validacija datuma i vremena
        $slobodniAsistenti = $this->zakazanaGrupaDezurniServis->pronadjiSveSlobodneAsistente($datum, $vreme);
        $slobodniJson = array();

        foreach($slobodniAsistenti as $slobodan) {
            $jsonObject = new \stdClass();
            $jsonObject->korisnickoIme = $slobodan->getKorisnickoIme();
            $jsonObject->imePrezime = $slobodan->getIme() . " " . $slobodan->getPrezime();

            $slobodniJson[] = $jsonObject;
        }

        header('Content-Type: application/json');
        echo json_encode($slobodniJson, JSON_PRETTY_PRINT);
    }


}