<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Sala
 *
 * @Table(name="sala", indexes={@Index(name="fk_Sala_Lokacija1_idx", columns={"lokacija"})})
 * @Entity
 */
class Sala
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="oznaka", type="string", length=45, nullable=false)
     */
    private $oznaka;

    /**
     * @var integer
     *
     * @Column(name="kapacitet", type="integer", nullable=false)
     */
    private $kapacitet;

    /**
     * @var string
     *
     * @Column(name="racunariKapacitet", type="string", length=45, nullable=false)
     */
    private $racunariKapacitet;

    /**
     * @var Lokacija
     *
     * @ManyToOne(targetEntity="Lokacija")
     * @JoinColumns({
     *   @JoinColumn(name="lokacija", referencedColumnName="id")
     * })
     */
    private $lokacija;


    /**
     * @OneToMany(targetEntity="ZakazanaGrupaSala", mappedBy="sala")
     */
    private $zakazaneGrupeSala;

    /**
     * @OneToMany(targetEntity="NajavljenaGrupaSala", mappedBy="sala")
     */
    private $najavljeneGrupeSala;

    public function __construct(){

        $this->zakazaneGrupeSala = new ArrayCollection();
        $this->najavljeneGrupeSala = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function setKapacitet($kapacitet)
    {
        $this->kapacitet = $kapacitet;

        return $this;
    }

    public function getKapacitet()
    {
        return $this->kapacitet;
    }

    public function setRacunariKapacitet($racunariKapacitet)
    {
        $this->racunariKapacitet = $racunariKapacitet;

        return $this;
    }

    public function getRacunariKapacitet()
    {
        return $this->racunariKapacitet;
    }

    public function setLokacija(Lokacija $lokacija = null)
    {
        $this->lokacija = $lokacija;

        return $this;
    }

    public function getLokacija()
    {
        return $this->lokacija;
    }

    public function getNajavljeneGrupeSala()
    {
        return $this->najavljeneGrupeSala;
    }

    public function setNajavljeneGrupeSala($najavljeneGrupeSala)
    {
        $this->najavljeneGrupeSala = $najavljeneGrupeSala;
    }

    public function getZakazaneGrupeSala()
    {
        return $this->zakazaneGrupeSala;
    }

    public function setZakazaneGrupeSala($zakazaneGrupeSala)
    {
        $this->zakazaneGrupeSala = $zakazaneGrupeSala;
    }
}
