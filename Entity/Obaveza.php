<?php


namespace AsistentPlusPlus\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Obaveza
 *
 * @Table(name="obaveza", indexes={@Index(name="fk_Obaveza_Nalog1_idx", columns={"korisnickoImeGlavnogDezurnog"})})
 * @Entity
 */
class Obaveza
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
     * @Column(name="nazivObaveze", type="string", length=45, nullable=false)
     */
    private $nazivObaveze;

    /**
     * @ManyToOne(targetEntity="Nalog")
     * @JoinColumns({
     *   @JoinColumn(name="korisnickoImeGlavnogDezurnog", referencedColumnName="korisnickoIme")
     * })
     */
    private $korisnickoImeGlavnogDezurnog;


    /**
     * @OneToMany(targetEntity="PredmetniAsistentiNaObavezi", mappedBy="obaveza")
     */
    private $predmetniAsistentiNaObavezi;



    public function __construct(){
        $this->predmetniAsistentiNaObavezi = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function setNazivObaveze($nazivObaveze)
    {
        $this->nazivObaveze = $nazivObaveze;

        return $this;
    }

    public function getNazivObaveze()
    {
        return $this->nazivObaveze;
    }

    public function setKorisnickoImeGlavnogDezurnog(Nalog $korisnickoImeGlavnogDezurnog = null)
    {
        $this->korisnickoImeGlavnogDezurnog = $korisnickoImeGlavnogDezurnog;

        return $this;
    }

    public function getKorisnickoImeGlavnogDezurnog()
    {
        return $this->korisnickoImeGlavnogDezurnog;
    }

    /**
     * @return mixed
     */
    public function getPredmetniAsistentiNaObavezi()
    {
        return $this->predmetniAsistentiNaObavezi;
    }

    /**
     * @param mixed $predmetniAsistentiNaObavezi
     */
    public function setPredmetniAsistentiNaObavezi($predmetniAsistentiNaObavezi)
    {
        $this->predmetniAsistentiNaObavezi = $predmetniAsistentiNaObavezi;
    }

}
