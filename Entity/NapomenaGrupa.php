<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Napomenagrupa
 *
 * @Table(name="napomenagrupa", uniqueConstraints={@UniqueConstraint(name="uc_korisnickoImeGlavnogDezurnogRbrZakazivanja", columns={"korisnickoImeGlavnogDezurnog", "rbrZakazivanja"})}, indexes={@Index(name="fk_NapomenaGrupa_ZakazanaGrupa1_idx", columns={"rbrZakazivanja"})})
 * @Entity
 */
class NapomenaGrupa
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
     * @Column(name="korisnickoImeGlavnogDezurnog", type="string", length=20, nullable=false)
     */
    private $korisnickoImeGlavnogDezurnog;

    /**
     * @var string
     *
     * @Column(name="napomena", type="string", length=100, nullable=false)
     */
    private $napomena;

    /**
     * @var \DateTime
     *
     * @Column(name="datumNapomene", type="date", nullable=false)
     */
    private $datumNapomene;

    /**
     * @var boolean
     *
     * @Column(name="vidljivost", type="boolean", nullable=true)
     */
    private $vidljivost;

    /**
     * @var ZakazanaGrupa
     *
     * @ManyToOne(targetEntity="ZakazanaGrupa")
     * @JoinColumns({
     *   @JoinColumn(name="rbrZakazivanja", referencedColumnName="rbrZakazivanja")
     * })
     */
    private $rbrZakazivanja;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setKorisnickoImeGlavnogDezurnog($korisnickoImeGlavnogDezurnog)
    {
        $this->korisnickoImeGlavnogDezurnog = $korisnickoImeGlavnogDezurnog;

        return $this;
    }


    public function getKorisnickoImeGlavnogDezurnog()
    {
        return $this->korisnickoImeGlavnogDezurnog;
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


    public function setDatumNapomene($datumNapomene)
    {
        $this->datumNapomene = $datumNapomene;

        return $this;
    }


    public function getDatumNapomene()
    {
        return $this->datumNapomene;
    }


    public function setVidljivost($vidljivost)
    {
        $this->vidljivost = $vidljivost;

        return $this;
    }


    public function getVidljivost()
    {
        return $this->vidljivost;
    }


    public function setRbrZakazivanja(Zakazanagrupa $rbrZakazivanja = null)
    {
        $this->rbrZakazivanja = $rbrZakazivanja;

        return $this;
    }

    public function getRbrZakazivanja()
    {
        return $this->rbrZakazivanja;
    }
}
