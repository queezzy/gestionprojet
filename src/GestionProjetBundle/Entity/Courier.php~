<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courier
 *
 * @ORM\Table(name="courier", indexes={@ORM\Index(name="fk_Courier_Intervenant1_idx", columns={"emetteur"})})
 * @ORM\Entity
 */
class Courier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCourier", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcourier;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="text", nullable=true)
     */
    private $objet;

    /**
     * @var \Intervenant
     *
     * @ORM\ManyToOne(targetEntity="Intervenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="emetteur", referencedColumnName="idIntervenant")
     * })
     */
    private $emetteur;

    /**
    * @ORM\OneToMany(targetEntity="Courierenvoye", mappedBy="idcourier", cascade={"remove", "persist"})
    */
    private $courierenvoyes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courierenvoyes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get idcourier
     *
     * @return integer 
     */
    public function getIdcourier()
    {
        return $this->idcourier;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Courier
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Courier
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set objet
     *
     * @param string $objet
     * @return Courier
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string 
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set emetteur
     *
     * @param \GestionProjetBundle\Entity\Intervenant $emetteur
     * @return Courier
     */
    public function setEmetteur(\GestionProjetBundle\Entity\Intervenant $emetteur = null)
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return \GestionProjetBundle\Entity\Intervenant 
     */
    public function getEmetteur()
    {
        return $this->emetteur;
    }
    
    /**
     * Add courierenvoye
     *
     * @param GestionProjetBundle\Entity\Courierenvoye $courierenvoye 
     * @return Courier
     */
    public function addCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoye)
    {
        $this->courierenvoyes[] = $courierenvoye;
        return $this;
    }
    
    /**
     * Get courierenvoyes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourierenvoyes()
    {
        return $this->courierenvoyes;
    }
    
    /**
     * Set courierenvoyes
     *
     * @param \Doctrine\Common\Collections\Collection $courierenvoyes
     * @return Courier
     */
    public function setCourierenvoyes(\Doctrine\Common\Collections\Collection $courierenvoyes = null)
    {
        $this->courierenvoyes = $courierenvoyes;

        return $this;
    }
    

    /**
     * Remove courierenvoyes
     *
     * @param \GestionProjetBundle\Entity\Courierenvoye $courierenvoyes
     */
    public function removeCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoyes)
    {
        $this->courierenvoyes->removeElement($courierenvoyes);
    }
}
