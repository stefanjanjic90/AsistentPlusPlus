<?php

namespace AsistentPlusPlus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PredmetniAsistentiNaObavezi
 *
 * @Table(name="predmetniasistentinaobavezi", uniqueConstraints={@UniqueConstraint(name="uc_korisnickoImeObaveza", columns={"korisnickoIme", "obaveza"})}, indexes={@Index(name="fk_asistentiNaObavezi_Obaveza1_idx", columns={"obaveza"}), @Index(name="IDX_1DD37BC8B452BAAE", columns={"korisnickoIme"})})
 * @Entity
 */
class PredmetniAsistentiNaObavezi
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
     *
     * @ManyToOne(targetEntity="Obaveza")
     * @JoinColumns({
     *   @JoinColumn(name="obaveza", referencedColumnName="id")
     * })
     */
    private $obaveza;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setKorisnickoIme(Nalog $korisnickoIme = null)
    {
        $this->korisnickoIme = $korisnickoIme;

        return $this;
    }

    public function getKorisnickoIme()
    {
        return $this->korisnickoIme;
    }

    public function setObaveza(Obaveza $obaveza = null)
    {
        $this->obaveza = $obaveza;

        return $this;
    }

    public function getObaveza()
    {
        return $this->obaveza;
    }
}
