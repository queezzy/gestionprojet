<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lot
 *
 * @ORM\Table(name="lot")
 * @ORM\Entity
 */
class Lot
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idLot", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlot;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime", nullable=true)
     */
    private $datefin;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tache", mappedBy="idlot")
     */
    private $idtache;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idtache = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idlot
     *
     * @return integer 
     */
    public function getIdlot()
    {
        return $this->idlot;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Lot
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Lot
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime 
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     * @return Lot
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime 
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Lot
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
     * @return Lot
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
     * Add idtache
     *
     * @param \GestionProjetBundle\Entity\Tache $idtache
     * @return Lot
     */
    public function addIdtache(\GestionProjetBundle\Entity\Tache $idtache)
    {
        $this->idtache[] = $idtache;

        return $this;
    }

    /**
     * Remove idtache
     *
     * @param \GestionProjetBundle\Entity\Tache $idtache
     */
    public function removeIdtache(\GestionProjetBundle\Entity\Tache $idtache)
    {
        $this->idtache->removeElement($idtache);
    }

    /**
     * Get idtache
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtache()
    {
        return $this->idtache;
    }
}
