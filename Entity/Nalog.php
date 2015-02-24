<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nalog
 *
 * @Table(name="nalog", indexes={@Index(name="fk_Nalog_Katedra_idx", columns={"katedra"})})
 * @Entity
 */
class Nalog
{
    /**
     * @var string
     *
     * @Column(name="korisnickoIme", type="string", length=20, nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $korisnickoIme;

    /**
     * @var string
     *
     * @Column(name="ime", type="string", length=45, nullable=false)
     */
    private $ime;

    /**
     * @var string
     *
     * @Column(name="prezime", type="string", length=100, nullable=false)
     */
    private $prezime;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="telefon", type="string", length=20, nullable=false)
     */
    private $telefon;

    /**
     * @var string
     *
     * @Column(name="lozinka", type="string", length=32, nullable=false)
     */
    private $lozinka;

    /**
     * @var boolean
     *
     * @Column(name="jeDezurni", type="boolean", nullable=false)
     */
    private $jeDezurni;

    /**
     * @var boolean
     *
     * @Column(name="jeAdministrator", type="boolean", nullable=false)
     */
    private $jeAdministrator;

    /**
     * @var boolean
     *
     * @Column(name="jeKoordinator", type="boolean", nullable=false)
     */
    private $jeKoordinator;

    /**
     * @var string
     *
     * @Column(name="opterecenje", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $opterecenje;

    /**
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @Column(name="napomena", type="string", length=100, nullable=true)
     */
    private $napomena;

    /**
     * @var float
     *
     * @Column(name="koeficijentAngazovanja", type="float", precision=10, scale=0, nullable=false)
     */
    private $koeficijentAngazovanja;

    /**
     * @var Katedra
     *
     * @ManyToOne(targetEntity="Katedra")
     * @JoinColumns({
     *   @JoinColumn(name="katedra", referencedColumnName="id")
     * })
     */
    private $katedra;

    /**
     * @OneToMany(targetEntity="Obaveza", mappedBy="korisnickoImeGlavnogDezurnog")
     */
    private $obaveze;

    /**
     * @OneToMany(targetEntity="PredmetniAsistentiNaObavezi", mappedBy="korisnickoIme")
     */
    private $predmetniAsistentiNaObavezi;

    /**
     * @OneToMany(targetEntity="ZakazanaGrupaDezurni", mappedBy="korisnickoIme")
     */
    private $zakazaneGrupeDezurni;

    /**
     * @OneToMany(targetEntity="PonudjeneZamene", mappedBy="korisnickoImePrimaoca")
     */
    private $ponudjeneZamene;

    public function __construct(){
        $this->obaveze = new ArrayCollection();
        $this->predmetniAsistentiNaObavezi = new ArrayCollection();
        $this->zakazaneGrupeDezurni = new ArrayCollection();
        $this->ponudjeneZamene = new ArrayCollection();
    }

    public function getKorisnickoIme()
    {
        return $this->korisnickoIme;
    }


    public function setKorisnickoIme($korisnickoIme)
    {
        $this->korisnickoIme = $korisnickoIme;
    }

    public function setIme($ime)
    {
        $this->ime = $ime;

        return $this;
    }

    public function getIme()
    {
        return $this->ime;
    }

    public function setPrezime($prezime)
    {
        $this->prezime = $prezime;

        return $this;
    }

    public function getPrezime()
    {
        return $this->prezime;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function getTelefon()
    {
        return $this->telefon;
    }

    public function setLozinka($lozinka)
    {
        $this->lozinka = $lozinka;

        return $this;
    }

    public function getLozinka()
    {
        return $this->lozinka;
    }

    public function setJeDezurni($jeDezurni)
    {
        $this->jeDezurni = $jeDezurni;

        return $this;
    }

    public function getJeDezurni()
    {
        return $this->jeDezurni;
    }

    public function setJeAdministrator($jeAdministrator)
    {
        $this->jeAdministrator = $jeAdministrator;

        return $this;
    }

    public function getJeAdministrator()
    {
        return $this->jeAdministrator;
    }


    public function setJeKoordinator($jeKoordinator)
    {
        $this->jeKoordinator = $jeKoordinator;

        return $this;
    }

    public function getJeKoordinator()
    {
        return $this->jeKoordinator;
    }

    public function setOpterecenje($opterecenje)
    {
        $this->opterecenje = $opterecenje;

        return $this;
    }

    public function getOpterecenje()
    {
        return $this->opterecenje;
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

    public function setNapomena($napomena)
    {
        $this->napomena = $napomena;

        return $this;
    }

    public function getNapomena()
    {
        return $this->napomena;
    }


    public function setKoeficijentAngazovanja($koeficijentAngazovanja)
    {
        $this->koeficijentAngazovanja = $koeficijentAngazovanja;

        return $this;
    }

    public function getKoeficijentAngazovanja()
    {
        return $this->koeficijentAngazovanja;
    }

    public function setKatedra( $katedra = null)
    {
        $this->katedra = $katedra;

        return $this;
    }

    public function getKatedra()
    {
        return $this->katedra;
    }

    public function getObaveze()
    {
        return $this->obaveze;
    }

    public function setObaveze($obaveze)
    {
        $this->obaveze = $obaveze;
    }

    public function getPredmetniAsistentiNaObavezi()
    {
        return $this->predmetniAsistentiNaObavezi;
    }

    public function setPredmetniAsistentiNaObavezi($predmetniAsistentiNaObavezi)
    {
        $this->predmetniAsistentiNaObavezi = $predmetniAsistentiNaObavezi;
    }

    public function getZakazaneGrupeDezurni()
    {
        return $this->zakazaneGrupeDezurni;
    }

    public function setZakazaneGrupeDezurni($zakazaneGrupeDezurni)
    {
        $this->zakazaneGrupeDezurni = $zakazaneGrupeDezurni;
    }

    public function getPonudjeneZamene()
    {
        return $this->ponudjeneZamene;
    }

    public function setPonudjeneZamene($ponudjeneZamene)
    {
        $this->ponudjeneZamene = $ponudjeneZamene;
    }
}
