<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervenant
 *
 * @ORM\Table(name="intervenant", indexes={@ORM\Index(name="fk_Intervenant_Projet1_idx", columns={"idProjet"}), @ORM\Index(name="fk_Intervenant_Adresse1_idx", columns={"idAdresse"}), @ORM\Index(name="fk_Intervenant_Lot1_idx", columns={"idLot"})})
 * @ORM\Entity
 */
class Intervenant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idIntervenant", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idintervenant;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="evolutionAttendu", type="string", length=255, nullable=true)
     */
    private $evolutionattendu;

    /**
     * @var string
     *
     * @ORM\Column(name="evolutionEncours", type="string", length=255, nullable=true)
     */
    private $evolutionencours;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text", nullable=true)
     */
    private $presentation;

    /**
     * @var string
     *
     * @ORM\Column(name="roleMission", type="text", nullable=true)
     */
    private $rolemission;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAdresse", referencedColumnName="idAdresse")
     * })
     */
    private $idadresse;

    /**
     * @var \Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLot", referencedColumnName="idLot")
     * })
     */
    private $idlot;

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
     * @ORM\ManyToMany(targetEntity="Courier", mappedBy="idintervenant")
     */
    private $idcourier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcourier = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idintervenant
     *
     * @return integer 
     */
    public function getIdintervenant()
    {
        return $this->idintervenant;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Intervenant
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
     * Set evolutionattendu
     *
     * @param string $evolutionattendu
     * @return Intervenant
     */
    public function setEvolutionattendu($evolutionattendu)
    {
        $this->evolutionattendu = $evolutionattendu;

        return $this;
    }

    /**
     * Get evolutionattendu
     *
     * @return string 
     */
    public function getEvolutionattendu()
    {
        return $this->evolutionattendu;
    }

    /**
     * Set evolutionencours
     *
     * @param string $evolutionencours
     * @return Intervenant
     */
    public function setEvolutionencours($evolutionencours)
    {
        $this->evolutionencours = $evolutionencours;

        return $this;
    }

    /**
     * Get evolutionencours
     *
     * @return string 
     */
    public function getEvolutionencours()
    {
        return $this->evolutionencours;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Intervenant
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
     * Set presentation
     *
     * @param string $presentation
     * @return Intervenant
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set rolemission
     *
     * @param string $rolemission
     * @return Intervenant
     */
    public function setRolemission($rolemission)
    {
        $this->rolemission = $rolemission;

        return $this;
    }

    /**
     * Get rolemission
     *
     * @return string 
     */
    public function getRolemission()
    {
        return $this->rolemission;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Intervenant
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
     * Set idadresse
     *
     * @param \GestionProjetBundle\Entity\Adresse $idadresse
     * @return Intervenant
     */
    public function setIdadresse(\GestionProjetBundle\Entity\Adresse $idadresse = null)
    {
        $this->idadresse = $idadresse;

        return $this;
    }

    /**
     * Get idadresse
     *
     * @return \GestionProjetBundle\Entity\Adresse 
     */
    public function getIdadresse()
    {
        return $this->idadresse;
    }

    /**
     * Set idlot
     *
     * @param \GestionProjetBundle\Entity\Lot $idlot
     * @return Intervenant
     */
    public function setIdlot(\GestionProjetBundle\Entity\Lot $idlot = null)
    {
        $this->idlot = $idlot;

        return $this;
    }

    /**
     * Get idlot
     *
     * @return \GestionProjetBundle\Entity\Lot 
     */
    public function getIdlot()
    {
        return $this->idlot;
    }

    /**
     * Set idprojet
     *
     * @param \GestionProjetBundle\Entity\Projet $idprojet
     * @return Intervenant
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
     * Add idcourier
     *
     * @param \GestionProjetBundle\Entity\Courier $idcourier
     * @return Intervenant
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
