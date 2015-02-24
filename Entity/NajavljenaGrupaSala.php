<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
/**
 * NajavljenaGrupaSala
 *
 * @Table(name="najavljenagrupasala", uniqueConstraints={@UniqueConstraint(name="uc_salaRbrNajave", columns={"sala", "rbrNajave"})}, indexes={@Index(name="fk_NajavljenaGrupaSala_NajavljenaGrupa1_idx", columns={"rbrNajave"}), @Index(name="IDX_C5E1C74FE226041C", columns={"sala"})})
 * @Entity
 */
class NajavljenaGrupaSala
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
     * @var NajavljenaGrupa
     *
     * @ManyToOne(targetEntity="NajavljenaGrupa")
     * @JoinColumns({
     *   @JoinColumn(name="rbrNajave", referencedColumnName="rbrNajave")
     * })
     */
    private $rbrNajave;


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

    public function setRbrNajave(NajavljenaGrupa $rbrnajave = null)
    {
        $this->rbrNajave = $rbrnajave;

        return $this;
    }


    public function getRbrNajave()
    {
        return $this->rbrNajave;
    }
}
