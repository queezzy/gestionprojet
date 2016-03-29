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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mail", mappedBy="idressource")
     */
    private $idmail;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Courier", inversedBy="idressource")
     * @ORM\JoinTable(name="ressource_courier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idRessource", referencedColumnName="idRessource")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idCourier", referencedColumnName="idCourier")
     *   }
     * )
     */
    private $idcourier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idmail = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcourier = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add idmail
     *
     * @param \GestionProjetBundle\Entity\Mail $idmail
     * @return Ressource
     */
    public function addIdmail(\GestionProjetBundle\Entity\Mail $idmail)
    {
        $this->idmail[] = $idmail;

        return $this;
    }

    /**
     * Remove idmail
     *
     * @param \GestionProjetBundle\Entity\Mail $idmail
     */
    public function removeIdmail(\GestionProjetBundle\Entity\Mail $idmail)
    {
        $this->idmail->removeElement($idmail);
    }

    /**
     * Get idmail
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdmail()
    {
        return $this->idmail;
    }

    /**
     * Add idcourier
     *
     * @param \GestionProjetBundle\Entity\Courier $idcourier
     * @return Ressource
     */
    public function addIdcourier(\GestionProjetBundle\Entity\Courier $idcourier)
    {
        $this->idcourier[] = $idcourier;

        return $this;
    }

    /**
     * Remove idcourier
     *
     * @param \GestionProjetBundle\Entity\Courier $idcourier
     */
    public function removeIdcourier(\GestionProjetBundle\Entity\Courier $idcourier)
    {
        $this->idcourier->removeElement($idcourier);
    }

    /**
     * Get idcourier
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcourier()
    {
        return $this->idcourier;
    }
}
