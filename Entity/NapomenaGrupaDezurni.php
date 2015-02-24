<?php


namespace AsistentPlusPlus\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * NapomenaGrupaDezurni
 *
 * @Table(name="napomenagrupadezurni", uniqueConstraints={@UniqueConstraint(name="uc_korisnickoImeGlavnogDezurnogKorisnickoImeRbrZakazivanja", columns={"zakazanaGrupaDezurniId", "korisnickoImeGlavnogDezurnog"})}, indexes={@Index(name="fk_NapomenaGrupaDezurni_ZakazanaGrupaDezurni1_idx", columns={"zakazanaGrupaDezurniId"})})
 * @Entity
 */
class NapomenaGrupaDezurni
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
     * @Column(name="datumNapomene", type="datetime", nullable=false)
     */
    private $datumNapomene = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @Column(name="vidljivost", type="boolean", nullable=true)
     */
    private $vidljivost;

    /**
     * @var boolean
     *
     * @Column(name="procitano", type="boolean", nullable=true)
     */
    private $procitano;

    /**
     * @var ZakazanaGrupaDezurni
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

    public function setProcitano($procitano)
    {
        $this->procitano = $procitano;

        return $this;
    }

    public function getProcitano()
    {
        return $this->procitano;
    }

    public function setZakazanaGrupaDezurniId(Zakazanagrupadezurni $zakazanaGrupaDezurniid = null)
    {
        $this->zakazanaGrupaDezurniId = $zakazanaGrupaDezurniid;

        return $this;
    }

    public function getZakazanaGrupaDezurniId()
    {
        return $this->zakazanaGrupaDezurniId;
    }
}
