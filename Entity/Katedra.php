<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Katedra
 * @T
 * @Table(name="katedra")
 * @Entity
 */
class Katedra
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="naziv", type="string", length=45, nullable=false)
     */
    private $naziv;

    /**
     * @OneToMany(targetEntity="Nalog", mappedBy="katedra")
     */
    private $nalozi;

    public function __construct(){
        $this->nalozi = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNaziv($naziv)
    {
        $this->naziv = $naziv;

        return $this;
    }

    public function getNaziv()
    {
        return $this->naziv;
    }

    public function getNalozi()
    {
        return $this->nalozi;
    }

    public function setNalozi($nalozi)
    {
        $this->nalozi = $nalozi;
    }
}
