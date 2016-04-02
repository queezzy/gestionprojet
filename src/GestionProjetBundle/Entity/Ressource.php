<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ressource
 *
 * @ORM\Table(name="ressource", indexes={@ORM\Index(name="fk_Ressource_Intervenant1_idx", columns={"idIntervenant"})})
 * @ORM\Entity
 */
class Ressource
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idRessource", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idressource;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=45, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

    /**
     * @var \Intervenant
     *
     * @ORM\ManyToOne(targetEntity="Intervenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idIntervenant", referencedColumnName="idIntervenant")
     * })
     */
    private $idintervenant;

    /**
    * @ORM\OneToMany(targetEntity="Courierenvoye", mappedBy="idressource", cascade={"remove", "persist"})
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
     * Get idressource
     *
     * @return integer 
     */
    public function getIdressource()
    {
        return $this->idressource;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Ressource
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Ressource
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
     * Set url
     *
     * @param string $url
     * @return Ressource
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ressource
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Ressource
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     * @return Ressource
     */
    public function setIdintervenant(\GestionProjetBundle\Entity\Intervenant $idintervenant = null)
    {
        $this->idintervenant = $idintervenant;

        return $this;
    }

    /**
     * Get idintervenant
     *
     * @return \GestionProjetBundle\Entity\Intervenant 
     */
    public function getIdintervenant()
    {
        return $this->idintervenant;
    }
    
    /**
     * Add courierenvoye
     *
     * @param GestionProjetBundle\Entity\Courierenvoye $courierenvoye 
     * @return Ressource
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
     * @return Ressource
     */
    public function setCourierenvoyes(\Doctrine\Common\Collections\Collection $courierenvoyes = null)
    {
        $this->courierenvoyes = $courierenvoyes;

        return $this;
    }
    
}
