<?php

namespace GestionProjetBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;


/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */

class Utilisateur extends BaseUser implements ParticipantInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var string
     *
     * @ORM\Column(name="personnelcle", type="integer", nullable=true)
     */
    private $personnelcle;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

    /**
     * @var \Intervenant
     *
     * @ORM\ManyToOne(targetEntity="Intervenant", inversedBy="utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idIntervenant", referencedColumnName="id")
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
     * @ORM\OneToMany(
     *   targetEntity="GestionProjetBundle\Entity\Message",
     *   mappedBy="sender",
     *   cascade={"all"}
     * )
     * @var Message[]|\Doctrine\Common\Collections\Collection
     */
    protected $messages;
    
    /**
     * @ORM\OneToMany(
     *   targetEntity="GestionProjetBundle\Entity\MessageMetadata",
     *   mappedBy="participant",
     *   cascade={"all"}
     * )
     * @var MessageMetadata[]|\Doctrine\Common\Collections\Collection
     */
    protected $messagemetadata;
    
    /**
     * @ORM\OneToMany(
     *   targetEntity="GestionProjetBundle\Entity\ThreadMetadata",
     *   mappedBy="participant",
     *   cascade={"all"}
     * )
     * @var ThreadMetadata[]|\Doctrine\Common\Collections\Collection
     */
    protected $threadmetadata;

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
     * Set personnelcle
     *
     * @param integer $personnelcle
     * @return Utilisateur
     */
    public function setPersonnelcle($personnelcle)
    {
        $this->personnelcle = $personnelcle;

        return $this;
    }

    /**
     * Get personnelcle
     *
     * @return integer 
     */
    public function getPersonnelcle()
    {
        return $this->personnelcle;
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

    /**
     * Add actualites
     *
     * @param \GestionProjetBundle\Entity\Actualite $actualites
     * @return Utilisateur
     */
    public function addActualite(\GestionProjetBundle\Entity\Actualite $actualites)
    {
        $this->actualites[] = $actualites;

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
     * Add message
     *
     * @param \GestionProjetBundle\Entity\Message $message
     * @return Utilisateur
     */
    public function addMessage(\GestionProjetBundle\Entity\Message $message)
    {
        $this->message[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \GestionProjetBundle\Entity\Message $message
     */
    public function removeMessage(\GestionProjetBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Add messagemetadata
     *
     * @param \GestionProjetBundle\Entity\MessageMetadata $messagemetadata
     * @return Utilisateur
     */
    public function addMessagemetadatum(\GestionProjetBundle\Entity\MessageMetadata $messagemetadata)
    {
        $this->messagemetadata[] = $messagemetadata;

        return $this;
    }

    /**
     * Remove messagemetadata
     *
     * @param \GestionProjetBundle\Entity\MessageMetadata $messagemetadata
     */
    public function removeMessagemetadatum(\GestionProjetBundle\Entity\MessageMetadata $messagemetadata)
    {
        $this->messagemetadata->removeElement($messagemetadata);
    }

    /**
     * Get messagemetadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessagemetadata()
    {
        return $this->messagemetadata;
    }

    /**
     * Add threadmetadata
     *
     * @param \GestionProjetBundle\Entity\ThreadMetadata $threadmetadata
     * @return Utilisateur
     */
    public function addThreadmetadatum(\GestionProjetBundle\Entity\ThreadMetadata $threadmetadata)
    {
        $this->threadmetadata[] = $threadmetadata;

        return $this;
    }

    /**
     * Remove threadmetadata
     *
     * @param \GestionProjetBundle\Entity\ThreadMetadata $threadmetadata
     */
    public function removeThreadmetadatum(\GestionProjetBundle\Entity\ThreadMetadata $threadmetadata)
    {
        $this->threadmetadata->removeElement($threadmetadata);
    }

    /**
     * Get threadmetadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThreadmetadata()
    {
        return $this->threadmetadata;
    }
}
