<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ZakazanaGrupaDezurni
 *
 * @Table(name="zakazanagrupadezurni", uniqueConstraints={@UniqueConstraint(name="uc_korisnickoImeRbrZakazivanja", columns={"korisnickoIme", "rbrZakazivanja"})}, indexes={@Index(name="fk_ZakazanaGrupaDezurni_Nalog1_idx", columns={"korisnickoIme"}), @Index(name="fk_ZakazanaGrupaDezurni_ZakazanaGrupa1_idx", columns={"rbrZakazivanja"})})
 * @Entity
 */
class ZakazanaGrupaDezurni
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
     * @var Nalog
     *
     * @ManyToOne(targetEntity="Nalog")
     * @JoinColumns({
     *   @JoinColumn(name="korisnickoIme", referencedColumnName="korisnickoIme")
     * })
     */
    private $korisnickoIme;

    /**
     * @var Zakazanagrupa
     *
     * @ManyToOne(targetEntity="ZakazanaGrupa")
     * @JoinColumns({
     *   @JoinColumn(name="rbrZakazivanja", referencedColumnName="rbrZakazivanja")
     * })
     */
    private $rbrZakazivanja;

    /**
     * @OneToMany(targetEntity="NapomenaGrupaDezurni", mappedBy="zakazanaGrupaDezurniId")
     */
    private $napomeneGrupeDezurni;

    /**
     * @OneToMany(targetEntity="PonudjeneZamene", mappedBy="zakazanaGrupaDezurniId")
     */
    private $ponudjeneZamene;

    public function __construct(){
        $this->napomeneGrupeDezurni = new ArrayCollection();
        $this->ponudjeneZamene = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setKorisnickoIme(Nalog $korisnickoime = null)
    {
        $this->korisnickoIme = $korisnickoime;

        return $this;
    }

    public function getKorisnickoIme()
    {
        return $this->korisnickoIme;
    }


    public function setRbrZakazivanja(ZakazanaGrupa $rbrZakazivanja = null)
    {
        $this->rbrZakazivanja = $rbrZakazivanja;

        return $this;
    }

    public function getRbrZakazivanja()
    {
        return $this->rbrZakazivanja;
    }

    public function getNapomeneGrupeDezurni()
    {
        return $this->napomeneGrupeDezurni;
    }

    public function setNapomeneGrupeDezurni($napomeneGrupeDezurni)
    {
        $this->napomeneGrupeDezurni = $napomeneGrupeDezurni;
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
