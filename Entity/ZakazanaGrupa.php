<?php


namespace AsistentPlusPlus\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Zakazanagrupa
 *
 * @Table(name="zakazanagrupa", indexes={@Index(name="fk_ZakazanaGrupa_NajavljenaGrupa1_idx", columns={"obaveza"})})
 * @Entity
 */
class ZakazanaGrupa
{
    /**
     * @var integer
     *
     * @Column(name="rbrZakazivanja", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $rbrZakazivanja;

    /**
     * @var integer
     *
     * @Column(name="grupa", type="integer", nullable=false)
     */
    private $grupa;

    /**
     * @var string
     *
     * @Column(name="oznaka", type="string", length=45, nullable=false)
     */
    private $oznaka;

    /**
     * @var \DateTime
     *
     * @Column(name="datum", type="date", nullable=false)
     */
    private $datum;

    /**
     * @var \DateTime
     *
     * @Column(name="pocetakRezervacije", type="time", nullable=false)
     */
    private $pocetakRezervacije;

    /**
     * @var \DateTime
     *
     * @Column(name="krajRezervacije", type="time", nullable=false)
     */
    private $krajRezervacije;

    /**
     * @var boolean
     *
     * @Column(name="trajanjeDezurstvaPredmetnogAsistenta", type="boolean", nullable=false)
     */
    private $trajanjeDezurstvaPredmetnogAsistenta;

    /**
     * @var \DateTime
     *
     * @Column(name="pocetakDezurstvaPomocnogDezurnog", type="time", nullable=false)
     */
    private $pocetakDezurstvaPomocnogDezurnog;

    /**
     * @var boolean
     *
     * @Column(name="trajanjeDezurstvaPomocnogDezurnog", type="boolean", nullable=false)
     */
    private $trajanjeDezurstvaPomocnogDezurnog;

    /**
     * @var boolean
     *
     * @Column(name="radNaRacunarima", type="boolean", nullable=false)
     */
    private $radNaRacunarima;

    /**
     * @var boolean
     *
     * @Column(name="brojDezurnih", type="boolean", nullable=false)
     */
    private $brojDezurnih;

    /**
     * @var string
     *
     * @Column(name="napomenaZaDezurne", type="string", length=45, nullable=true)
     */
    private $napomenaZaDezurne;

    /**
     * @var integer
     *
     * @Column(name="brojOcekivanihStudenata", type="integer", nullable=true)
     */
    private $brojOcekivanihStudenata;

    /**
     * @var integer
     *
     * @Column(name="brojPrijavljenih", type="integer", nullable=true)
     */
    private $brojPrijavljenih;

    /**
     * @var integer
     *
     * @Column(name="brojIzaslih", type="integer", nullable=true)
     */
    private $brojIzaslih;

    /**
     * @var \DateTime
     *
     * @Column(name="datumObrade", type="date", nullable=false)
     */
    private $datumObrade;

    /**
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @OneToOne(targetEntity="NajavljenaGrupa")
     * @JoinColumn(name="rbrNajave", referencedColumnName="rbrNajave")
     */
    private $rbrNajave;

    /**
     * @OneToMany(targetEntity="ZakazanaGrupaDezurni", mappedBy="rbrZakazivanja")
     */
    private $zakazaneGrupeDezurni;

    /**
    * @OneToMany(targetEntity="ZakazanaGrupaSala", mappedBy="rbrZakazivanja")
    */
    private $zakazaneGrupeSala;

    /**
     * @OneToMany(targetEntity="NapomenaGrupa", mappedBy="rbrZakazivanja")
     */
    private $napomeneGrupa;

    public function __construct(){
        $this->zakazaneGrupeDezurni = new ArrayCollection();
        $this->zakazaneGrupeSala= new ArrayCollection();
        $this->napomeneGrupa = new ArrayCollection();
    }

    public function getRbrZakazivanja()
    {
        return $this->rbrZakazivanja;
    }

    public function setRbrZakazivanja($rbrZakazivanja)
    {
        $this->rbrZakazivanja = $rbrZakazivanja;
    }

    public function setGrupa($grupa)
    {
        $this->grupa = $grupa;

        return $this;
    }

    public function getGrupa()
    {
        return $this->grupa;
    }

    public function setOznaka($oznaka)
    {
        $this->oznaka = $oznaka;

        return $this;
    }

    public function getOznaka()
    {
        return $this->oznaka;
    }

    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    public function getDatum()
    {
        return $this->datum;
    }

    public function setPocetakRezervacije($pocetakRezervacije)
    {
        $this->pocetakRezervacije = $pocetakRezervacije;

        return $this;
    }

    public function getPocetakRezervacije()
    {
        return $this->pocetakRezervacije;
    }

    public function setKrajRezervacije($krajRezervacije)
    {
        $this->krajRezervacije = $krajRezervacije;

        return $this;
    }

    public function getKrajRezervacije()
    {
        return $this->krajRezervacije;
    }

    public function setTrajanjeDezurstvaPredmetnogAsistenta($trajanjeDezurstvaPredmetnogAsistenta)
    {
        $this->trajanjeDezurstvaPredmetnogAsistenta = $trajanjeDezurstvaPredmetnogAsistenta;

        return $this;
    }

    public function getTrajanjeDezurstvaPredmetnogAsistenta()
    {
        return $this->trajanjeDezurstvaPredmetnogAsistenta;
    }

    public function setPocetakDezurstvaPomocnogDezurnog($pocetakDezurstvaPomocnogDezurnog)
    {
        $this->pocetakDezurstvaPomocnogDezurnog = $pocetakDezurstvaPomocnogDezurnog;

        return $this;
    }

    public function getPocetakDezurstvaPomocnogDezurnog()
    {
        return $this->pocetakDezurstvaPomocnogDezurnog;
    }

    public function setTrajanjeDezurstvaPomocnogDezurnog($trajanjeDezurstvaPomocnogDezurnog)
    {
        $this->trajanjeDezurstvaPomocnogDezurnog = $trajanjeDezurstvaPomocnogDezurnog;

        return $this;
    }

    public function getTrajanjeDezurstvaPomocnogDezurnog()
    {
        return $this->trajanjeDezurstvaPomocnogDezurnog;
    }


    public function setRadNaRacunarima($radNaRacunarima)
    {
        $this->radNaRacunarima = $radNaRacunarima;

        return $this;
    }

    public function getRadNaRacunarima()
    {
        return $this->radNaRacunarima;
    }

    public function setBrojDezurnih($brojDezurnih)
    {
        $this->brojDezurnih = $brojDezurnih;

        return $this;
    }

    public function getBrojDezurnih()
    {
        return $this->brojDezurnih;
    }

    public function setNapomenaZaDezurne($napomenaZaDezurne)
    {
        $this->napomenaZaDezurne = $napomenaZaDezurne;

        return $this;
    }

    public function getNapomenaZaDezurne()
    {
        return $this->napomenaZaDezurne;
    }

    public function setBrojOcekivanihStudenata($brojOcekivanihStudenata)
    {
        $this->brojOcekivanihStudenata = $brojOcekivanihStudenata;

        return $this;
    }

    public function getBrojOcekivanihStudenata()
    {
        return $this->brojOcekivanihStudenata;
    }

    public function setBrojPrijavljenih($brojPrijavljenih)
    {
        $this->brojPrijavljenih = $brojPrijavljenih;

        return $this;
    }

    public function getBrojPrijavljenih()
    {
        return $this->brojPrijavljenih;
    }

    public function setBrojIzaslih($brojIzaslih)
    {
        $this->brojIzaslih = $brojIzaslih;

        return $this;
    }

    public function getBrojIzaslih()
    {
        return $this->brojIzaslih;
    }

    public function setDatumObrade($datumObrade)
    {
        $this->datumObrade = $datumObrade;

        return $this;
    }

    public function getDatumObrade()
    {
        return $this->datumObrade;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getRbrNajave()
    {
        return $this->rbrNajave;
    }

    public function setRbrNajave($rbrNajave)
    {
        $this->rbrNajave = $rbrNajave;
    }

    public function getZakazaneGrupeDezurni()
    {
        return $this->zakazaneGrupeDezurni;
    }

    public function setZakazaneGrupeDezurni($zakazaneGrupeDezurni)
    {
        $this->zakazaneGrupeDezurni = $zakazaneGrupeDezurni;
    }

    public function getZakazaneGrupeSala()
    {
        return $this->zakazaneGrupeSala;
    }

    public function setZakazaneGrupeSala($zakazaneGrupeSala)
    {
        $this->zakazaneGrupeSala = $zakazaneGrupeSala;
    }

    public function getNapomeneGrupa()
    {
        return $this->napomeneGrupa;
    }

    public function setNapomeneGrupa($napomeneGrupa)
    {
        $this->napomeneGrupa = $napomeneGrupa;
    }
}
