<?php


namespace AsistentPlusPlus\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ZakazanaGrupaSala
 *
 * @Table(name="zakazanagrupasala", uniqueConstraints={@UniqueConstraint(name="uc_salaRbrZakazivanja", columns={"sala", "rbrZakazivanja"})}, indexes={@Index(name="fk_ZakazanaGrupaSala_ZakazanaGrupa1_idx", columns={"rbrZakazivanja"}), @Index(name="IDX_8EA89446E226041C", columns={"sala"})})
 * @Entity
 */
class ZakazanaGrupaSala
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
     * @var Sala
     *
     * @ManyToOne(targetEntity="Sala")
     * @JoinColumns({
     *   @JoinColumn(name="sala", referencedColumnName="id")
     * })
     */
    private $sala;

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

    public function setSala(Sala $sala = null)
    {
        $this->sala = $sala;

        return $this;
    }

    public function getSala()
    {
        return $this->sala;
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
}
