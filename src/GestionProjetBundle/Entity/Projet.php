<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity
 */
class Projet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProjet", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprojet;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255, nullable=true)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @var integer
     *
     * @ORM\Column(name="budget", type="bigint", nullable=true)
     */
    private $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="demandeur", type="string", length=255, nullable=true)
     */
    private $demandeur;

    /**
     * @var float
     *
     * @ORM\Column(name="evolutionAttendu", type="float", precision=10, scale=0, nullable=true)
     */
    private $evolutionattendu;

    /**
     * @var float
     *
     * @ORM\Column(name="evolutionEncours", type="float", precision=10, scale=0, nullable=true)
     */
    private $evolutionencours;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

/**
    * @ORM\OneToMany(targetEntity="Intervenant", mappedBy="idprojet", cascade={"remove", "persist"})
    */
    private $intervenants;
    
    /**
    * @ORM\OneToMany(targetEntity="Tache", mappedBy="idprojet", cascade={"remove", "persist"})
    */
    private $taches;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intervenants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->taches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idprojet
     *
     * @return integer 
     */
    public function getIdprojet()
    {
        return $this->idprojet;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Projet
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     * @return Projet
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Projet
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
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Projet
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
     * @return Projet
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
     * Set budget
     *
     * @param integer $budget
     * @return Projet
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set demandeur
     *
     * @param string $demandeur
     * @return Projet
     */
    public function setDemandeur($demandeur)
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    /**
     * Get demandeur
     *
     * @return string 
     */
    public function getDemandeur()
    {
        return $this->demandeur;
    }

    /**
     * Set evolutionattendu
     *
     * @param float $evolutionattendu
     * @return Projet
     */
    public function setEvolutionattendu($evolutionattendu)
    {
        $this->evolutionattendu = $evolutionattendu;

        return $this;
    }

    /**
     * Get evolutionattendu
     *
     * @return float 
     */
    public function getEvolutionattendu()
    {
        return $this->evolutionattendu;
    }

    /**
     * Set evolutionencours
     *
     * @param float $evolutionencours
     * @return Projet
     */
    public function setEvolutionencours($evolutionencours)
    {
        $this->evolutionencours = $evolutionencours;

        return $this;
    }

    /**
     * Get evolutionencours
     *
     * @return float 
     */
    public function getEvolutionencours()
    {
        return $this->evolutionencours;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Projet
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
     * Add intervenant
     *
     * @param GestionProjetBundle\Entity\Intervenant $intervenant 
     * @return Projet
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
     * @return Projet
     */
    public function setIntervenants(\Doctrine\Common\Collections\Collection $intervenants = null)
    {
        $this->intervenants = $intervenants;

        return $this;
    }
}
