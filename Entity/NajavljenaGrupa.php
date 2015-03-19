<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NajavljenaGrupa
 *
 * @Table(name="najavljenagrupa", indexes={@Index(name="fk_Grupa_Obaveza2_idx", columns={"obaveza"}), @Index(name="key", columns={"rbrNajave"})})
 * @Entity
 */
class NajavljenaGrupa
{
    /**
     * @var integer
     *
     * @Column(name="rbrNajave", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $rbrNajave;

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
     * @Column(name="datum", type="date", nullable=true)
     */
    private $datum;

    /**
     * @var \DateTime
     *
     * @Column(name="pocetakRezervacije", type="time", nullable=true)
     */
    private $pocetakRezervacije;

    /**
     * @var \DateTime
     *
     * @Column(name="krajRezervacije", type="time", nullable=true)
     */
    private $krajRezervacije;

    /**
     * @var integer
     *
     * @Column(name="trajanjeDezurstvaPredmetnogAsistenta", type="integer", nullable=false)
     */
    private $trajanjeDezurstvaPredmetnogAsistenta;

    /**
     * @var \DateTime
     *
     * @Column(name="pocetakDezurstvaPomocnogDezurnog", type="time", nullable=true)
     */
    private $pocetakDezurstvaPomocnogDezurnog;

    /**
     * @var integer
     *
     * @Column(name="trajanjeDezurstvaPomocnogDezurnog", type="integer", nullable=false)
     */
    private $trajanjeDezurstvaPomocnogDezurnog;

    /**
     * @var boolean
     *
     * @Column(name="radNaRacunarima", type="boolean", nullable=false)
     */
    private $radNaRacunarima;

    /**
     * @var integer
     *
     * @Column(name="brojDezurnih", type="integer", nullable=false)
     */
    private $brojDezurnih;

    /**
     * @var string
     *
     * @Column(name="napomenaZaKoordinatora", type="string", length=45, nullable=true)
     */
    private $napomenaZaKoordinatora;

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
     * @var \DateTime
     *
     * @Column(name="datumNajave", type="date", nullable=false)
     */
    private $datumNajave;

    /**
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     *
     * @ManyToOne(targetEntity="Obaveza")
     * @JoinColumns({
     *   @JoinColumn(name="obaveza", referencedColumnName="id")
     * })
     */
    private $obaveza;

    /**
     * @OneToMany(targetEntity="NajavljenaGrupaSala", mappedBy="rbrNajave")
     */
    private $najavljeneGrupeSala;


    /**
     * @OneToOne(targetEntity="NajavljenaGrupa")
     * @JoinColumn(name="rbrNajave", referencedColumnName="rbrNajave")
     */
    private $zakazanaGrupa;


    public function __construct(){
        $this->najavljeneGrupeSala = new ArrayCollection();
    }

    public function getRbrNajave()
    {
        return $this->rbrNajave;
    }


    public function setRbrNajave($rbrNajave)
    {
        $this->rbrNajave = $rbrNajave;
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


    public function setNapomenaZaKoordinatora($napomenaZaKoordinatora)
    {
        $this->napomenaZaKoordinatora = $napomenaZaKoordinatora;

        return $this;
    }


    public function getNapomenaZaKoordinatora()
    {
        return $this->napomenaZaKoordinatora;
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


    public function setDatumNajave($datumNajave)
    {
        $this->datumNajave = $datumNajave;

        return $this;
    }


    public function getDatumNajave()
    {
        return $this->datumNajave;
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


    public function setObaveza(Obaveza $obaveza = null)
    {
        $this->obaveza = $obaveza;

        return $this;
    }


    public function getObaveza()
    {
        return $this->obaveza;
    }

    public function getZakazanaGrupa()
    {
        return $this->zakazanaGrupa;
    }

    public function setZakazanaGrupa($zakazaneGrupe)
    {
        $this->zakazanaGrupa = $zakazaneGrupe;
    }

    public function getNajavljeneGrupeSala()
    {
        return $this->najavljeneGrupeSala;
    }

    public function setNajavljeneGrupeSala($najavljeneGrupeSala)
    {
        $this->najavljeneGrupeSala = $najavljeneGrupeSala;
    }
}
