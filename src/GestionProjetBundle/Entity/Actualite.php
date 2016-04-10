<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actualite
 *
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="GestionProjetBundle\Repository\ActualiteRepository")
 */
class Actualite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="datePublication", type="string", length=255, nullable=true)
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=true)
     */
    private $contenu;

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
     * @var \Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="actualites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTheme", referencedColumnName="id")
     * })
     */
    private $idtheme;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur",inversedBy="actualites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $utilisateur;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Actualite
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
     * Set datepublication
     *
     * @param string $datepublication
     * @return Actualite
     */
    public function setDatepublication($datepublication)
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    /**
     * Get datepublication
     *
     * @return string 
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Actualite
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Actualite
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
     * @return Actualite
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
     * Set idtheme
     *
     * @param \GestionProjetBundle\Entity\Theme $idtheme
     * @return Actualite
     */
    public function setIdtheme(\GestionProjetBundle\Entity\Theme $idtheme = null)
    {
        $this->idtheme = $idtheme;

        return $this;
    }

    /**
     * Get idtheme
     *
     * @return \GestionProjetBundle\Entity\Theme 
     */
    public function getIdtheme()
    {
        return $this->idtheme;
    }

    /**
     * Set utilisateur
     *
     * @param \GestionProjetBundle\Entity\Utilisateur $utilisateur
     * @return Actualite
     */
    public function setUtilisateur(\GestionProjetBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \GestionProjetBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
