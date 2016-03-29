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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Intervenant", inversedBy="idcourier")
     * @ORM\JoinTable(name="courier_intervenant",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idCourier", referencedColumnName="idCourier")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idIntervenant", referencedColumnName="idIntervenant")
     *   }
     * )
     */
    private $idintervenant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ressource", mappedBy="idcourier")
     */
    private $idressource;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idintervenant = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idressource = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     * @return Courier
     */
    public function addIdintervenant(\GestionProjetBundle\Entity\Intervenant $idintervenant)
    {
        $this->idintervenant[] = $idintervenant;

        return $this;
    }

    /**
     * Remove idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     */
    public function removeIdintervenant(\GestionProjetBundle\Entity\Intervenant $idintervenant)
    {
        $this->idintervenant->removeElement($idintervenant);
    }

    /**
     * Get idintervenant
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdintervenant()
    {
        return $this->idintervenant;
    }

    /**
     * Add idressource
     *
     * @param \GestionProjetBundle\Entity\Ressource $idressource
     * @return Courier
     */
    public function addIdressource(\GestionProjetBundle\Entity\Ressource $idressource)
    {
        $this->idressource[] = $idressource;

        return $this;
    }

    /**
     * Remove idressource
     *
     * @param \GestionProjetBundle\Entity\Ressource $idressource
     */
    public function removeIdressource(\GestionProjetBundle\Entity\Ressource $idressource)
    {
        $this->idressource->removeElement($idressource);
    }

    /**
     * Get idressource
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdressource()
    {
        return $this->idressource;
    }
}
