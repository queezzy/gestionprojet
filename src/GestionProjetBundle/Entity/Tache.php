<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table(name="tache", indexes={@ORM\Index(name="fk_Tache_Projet1_idx", columns={"idProjet"})})
 * @ORM\Entity
 */
class Tache
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTache", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtache;

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
     * @var \Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProjet", referencedColumnName="idProjet")
     * })
     */
    private $idprojet;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lot", inversedBy="idtache")
     * @ORM\JoinTable(name="tache_lot",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idTache", referencedColumnName="idTache")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idLot", referencedColumnName="idLot")
     *   }
     * )
     */
    private $idlot;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idlot = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idtache
     *
     * @return integer 
     */
    public function getIdtache()
    {
        return $this->idtache;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Tache
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
     * @return Tache
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
     * @return Tache
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
     * @return Tache
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
     * @return Tache
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
     * Set idprojet
     *
     * @param \GestionProjetBundle\Entity\Projet $idprojet
     * @return Tache
     */
    public function setIdprojet(\GestionProjetBundle\Entity\Projet $idprojet = null)
    {
        $this->idprojet = $idprojet;

        return $this;
    }

    /**
     * Get idprojet
     *
     * @return \GestionProjetBundle\Entity\Projet 
     */
    public function getIdprojet()
    {
        return $this->idprojet;
    }

    /**
     * Add idlot
     *
     * @param \GestionProjetBundle\Entity\Lot $idlot
     * @return Tache
     */
    public function addIdlot(\GestionProjetBundle\Entity\Lot $idlot)
    {
        $this->idlot[] = $idlot;

        return $this;
    }

    /**
     * Remove idlot
     *
     * @param \GestionProjetBundle\Entity\Lot $idlot
     */
    public function removeIdlot(\GestionProjetBundle\Entity\Lot $idlot)
    {
        $this->idlot->removeElement($idlot);
    }

    /**
     * Get idlot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdlot()
    {
        return $this->idlot;
    }
}
