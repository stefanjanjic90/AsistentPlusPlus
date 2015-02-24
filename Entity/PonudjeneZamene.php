<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PonudjeneZamene
 *
 * @Table(name="ponudjenezamene", uniqueConstraints={@UniqueConstraint(name="uc_korisnickoImePosiljaocaKorisnickoImePrimaocaRbrZakazivanja", columns={"zakazanaGrupaDezurniId", "korisnickoImePrimaoca"})}, indexes={@Index(name="fk_PonudjeneZamene_Nalog1_idx", columns={"korisnickoImePrimaoca"}), @Index(name="IDX_20F4230CBA663567", columns={"zakazanaGrupaDezurniId"})})
 * @Entity
 */
class PonudjeneZamene
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
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var Nalog
     *
     * @ManyToOne(targetEntity="Nalog")
     * @JoinColumns({
     *   @JoinColumn(name="korisnickoImePrimaoca", referencedColumnName="korisnickoIme")
     * })
     */
    private $korisnickoImePrimaoca;

    /**
     * @var Zakazanagrupadezurni
     *
     * @ManyToOne(targetEntity="ZakazanaGrupaDezurni")
     * @JoinColumns({
     *   @JoinColumn(name="zakazanaGrupaDezurniId", referencedColumnName="id")
     * })
     */
    private $zakazanaGrupaDezurniId;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function setKorisnickoImePrimaoca(Nalog $korisnickoImePrimaoca = null)
    {
        $this->korisnickoImePrimaoca = $korisnickoImePrimaoca;

        return $this;
    }

    public function getKorisnickoImePrimaoca()
    {
        return $this->korisnickoImePrimaoca;
    }


    public function setZakazanaGrupaDezurniId(Zakazanagrupadezurni $zakazanaGrupaDezurniId = null)
    {
        $this->zakazanaGrupaDezurniId = $zakazanaGrupaDezurniId;

        return $this;
    }

    public function getZakazanaGrupaDezurniId()
    {
        return $this->zakazanaGrupaDezurniId;
    }
}
