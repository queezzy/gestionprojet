<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme", indexes={@ORM\Index(name="fk_Theme_Projet1_idx", columns={"idProjet"})})
 * @ORM\Entity
 */
class Theme
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTheme", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtheme;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

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
    * @ORM\OneToMany(targetEntity="Actualite", mappedBy="idtheme", cascade={"remove", "persist"})
    */
    private $actualites;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actualites = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get idtheme
     *
     * @return integer 
     */
    public function getIdtheme()
    {
        return $this->idtheme;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Theme
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
     * Set description
     *
     * @param string $description
     * @return Theme
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
     * @return Theme
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
     * @return Theme
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
     * Add actualite
     *
     * @param GestionProjetBundle\Entity\Actualite $actualite 
     * @return Theme
     */
    public function addActualite(\GestionProjetBundle\Entity\Actualite $actualite)
    {
        $this->actualites[] = $actualite;
        return $this;
    }
    
    /**
     * Get actualites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActualites()
    {
        return $this->actualites;
    }
    
    /**
     * Set actualites
     *
     * @param \Doctrine\Common\Collections\Collection $actualites
     * @return Theme
     */
    public function setActualites(\Doctrine\Common\Collections\Collection $actualites = null)
    {
        $this->actualites = $actualites;

        return $this;
    }

    /**
     * Remove actualites
     *
     * @param \GestionProjetBundle\Entity\Actualite $actualites
     */
    public function removeActualite(\GestionProjetBundle\Entity\Actualite $actualites)
    {
        $this->actualites->removeElement($actualites);
    }
}
