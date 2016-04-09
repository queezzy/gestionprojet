<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="calendrier")
 * @ORM\Entity
 */
class Calendrier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idcalendrier;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=false)
     */
    private $statut;

   
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
     * @ORM\Column(name="titre", type="string", nullable=false,length=255)
     */
    private $titre;
    
    /**
     * @var text
     *
     * @ORM\Column(name="description", type="string", nullable=false)
     */
    private $description;
    
    
     /**
     * @var text
     *
     * @ORM\Column(name="evenementlongueperiode", type="boolean", nullable=false)
     */
    private $evenementlongueperiode;

   
    

    /**
     * Get idcalendrier
     *
     * @return integer 
     */
    public function getIdcalendrier()
    {
        return $this->idcalendrier;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Calendrier
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
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Calendrier
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
     * @return Calendrier
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
     * Set titre
     *
     * @param string $titre
     * @return Calendrier
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Calendrier
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
     * Set evenementlongueperiode
     *
     * @param boolean $evenementlongueperiode
     * @return Calendrier
     */
    public function setEvenementlongueperiode($evenementlongueperiode)
    {
        $this->evenementlongueperiode = $evenementlongueperiode;

        return $this;
    }

    /**
     * Get evenementlongueperiode
     *
     * @return boolean 
     */
    public function getEvenementlongueperiode()
    {
        return $this->evenementlongueperiode;
    }
}
