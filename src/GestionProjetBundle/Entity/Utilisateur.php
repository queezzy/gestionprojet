<?php

namespace GestionProjetBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;


/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="fk_Utilisateur_Intervenant1_idx", columns={"idIntervenant"})})
 * @ORM\Entity
 */
class Utilisateur extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUtilisateur", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

   
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
     * @ORM\ManyToMany(targetEntity="Mail", mappedBy="utilisateurs")
     */
    private $mails;
    
     /**
     *@ORM\OneToMany(targetEntity="Actualite",mappedBy="utilisateur")
     
     */
    
    private $actualites;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mails = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
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
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     * @return Utilisateur
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Utilisateur
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
     * Set telephone
     *
     * @param string $telephone
     * @return Utilisateur
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

   

    

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Utilisateur
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
     * @return Utilisateur
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
     * Add mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     * @return Utilisateur
     */
    public function addMails(\GestionProjetBundle\Entity\Mail $mails)
    {
        $this->mails[] = $mails;

        return $this;
    }

    /**
     * Remove mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     */
    public function removeMail(\GestionProjetBundle\Entity\Mail $mails)
    {
        $this->mails->removeElement($mails);
    }

    /**
     * Get mails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMails()
    {
        return $this->mails;
    }

    /**
     * Add mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     * @return Utilisateur
     */
    public function addMail(\GestionProjetBundle\Entity\Mail $mails)
    {
        $this->mails[] = $mails;

        return $this;
    }
}
