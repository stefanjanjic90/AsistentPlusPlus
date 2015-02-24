<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Lokacija
 *
 * @Table(name="lokacija")
 * @Entity
 */
class Lokacija
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
     * @Column(name="opis", type="string", length=45, nullable=false)
     */
    private $opis;

    /**
     * @var string
     *
     * @Column(name="adresa", type="string", length=45, nullable=false)
     */
    private $adresa;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @OneToMany(targetEntity="Sala", mappedBy="lokacija")
     */
    private $sale;

    public function __construct(){
        $this->sale = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    public function getOpis()
    {
        return $this->opis;
    }

    public function setAdresa($adresa)
    {
        $this->adresa = $adresa;

        return $this;
    }

    public function getAdresa()
    {
        return $this->adresa;
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

    public function getSale()
    {
        return $this->sale;
    }

    public function setSale($sale)
    {
        $this->sale = $sale;
    }
}
