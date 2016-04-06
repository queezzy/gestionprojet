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
     * @ORM\GeneratedValue(strategy="AUTO")
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
    private $taches;
    
    /**
    * @ORM\OneToMany(targetEntity="Intervenant", mappedBy="idlot", cascade={"remove", "persist"})
    */
    private $intervenants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->taches = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intervenants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add taches
     *
     * @param \GestionProjetBundle\Entity\Tache $tache
     * @return Lot
     */
    public function addTache(\GestionProjetBundle\Entity\Tache $tache)
    {
        $this->taches[] = $tache;

        return $this;
    }

    /**
     * Remove tache
     *
     * @param \GestionProjetBundle\Entity\Tache $tache
     */
    public function removeTache(\GestionProjetBundle\Entity\Tache $tache)
    {
        $this->taches->removeElement($tache);
    }

    /**
     * Get taches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTaches()
    {
        return $this->taches;
    }
    
    /**
     * Set taches
     *
     * @param \Doctrine\Common\Collections\Collection $taches
     * @return Lot
     */
    public function setTaches(\Doctrine\Common\Collections\Collection $taches = null)
    {
        $this->taches = $taches;

        return $this;
    }
    
    /**
     * Add intervenant
     *
     * @param GestionProjetBundle\Entity\Intervenant $intervenant 
     * @return Lot
     */
    public function addIntervenant(\GestionProjetBundle\Entity\Intervenant $intervenant)
    {
        $this->intervenants[] = $intervenant;
        return $this;
    }
    
    /**
     * Get intervenants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntervenants()
    {
        return $this->intervenants;
    }
    
    /**
     * Set intervenants
     *
     * @param \Doctrine\Common\Collections\Collection $intervenants
     * @return Lot
     */
    public function setIntervenants(\Doctrine\Common\Collections\Collection $intervenants = null)
    {
        $this->intervenants = $intervenants;

        return $this;
    }
    
}
