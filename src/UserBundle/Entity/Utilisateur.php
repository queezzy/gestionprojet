<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Utilisateur extends BaseUser implements ParticipantInterface {

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
     * @var boolean
     *
     * @ORM\Column(name="personnelcle", type="boolean", nullable=false)
     */
    private $personnelcle;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

    /**
     * @var \GestionProjetBundle\Intervenant
     *
     * @ORM\ManyToOne(targetEntity="\GestionProjetBundle\Entity\Intervenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idIntervenant", referencedColumnName="id")
     * })
     */
    private $idintervenant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\GestionProjetBundle\Entity\Mail", mappedBy="utilisateurs")
     */
    private $mails;

    /**
     * @ORM\OneToMany(targetEntity="\GestionProjetBundle\Entity\Actualite",mappedBy="utilisateur")
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
     * @ORM\Column(type="string", length=255, nullable=true) 
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000") 
     */
    private $file;
    
    private $temp;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->mails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statut = 1;
        $this->personnelcle = false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     * @return Utilisateur
     */
    public function setFonction($fonction) {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction() {
        return $this->fonction;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Utilisateur
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Utilisateur
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer 
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Set personnelcle
     *
     * @param integer $personnelcle
     * @return Utilisateur
     */
    public function setPersonnelcle($personnelcle) {
        $this->personnelcle = $personnelcle;

        return $this;
    }

    /**
     * Get personnelcle
     *
     * @return integer 
     */
    public function getPersonnelcle() {
        return $this->personnelcle;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Utilisateur
     */
    public function setStatut($statut) {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Set idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     * @return Utilisateur
     */
    public function setIdintervenant(\GestionProjetBundle\Entity\Intervenant $idintervenant = null) {
        $this->idintervenant = $idintervenant;

        return $this;
    }

    /**
     * Get idintervenant
     *
     * @return \GestionProjetBundle\Entity\Intervenant 
     */
    public function getIdintervenant() {
        return $this->idintervenant;
    }

    /**
     * Add mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     * @return Utilisateur
     */
    public function addMails(\GestionProjetBundle\Entity\Mail $mails) {
        $this->mails[] = $mails;

        return $this;
    }

    /**
     * Remove mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     */
    public function removeMail(\GestionProjetBundle\Entity\Mail $mails) {
        $this->mails->removeElement($mails);
    }

    /**
     * Get mails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMails() {
        return $this->mails;
    }

    /**
     * Add mails
     *
     * @param \GestionProjetBundle\Entity\Mail $mails
     * @return Utilisateur
     */
    public function addMail(\GestionProjetBundle\Entity\Mail $mails) {
        $this->mails[] = $mails;

        return $this;
    }

    /**
     * Add actualites
     *
     * @param \GestionProjetBundle\Entity\Actualite $actualites
     * @return Utilisateur
     */
    public function addActualite(\GestionProjetBundle\Entity\Actualite $actualites) {
        $this->actualites[] = $actualites;

        return $this;
    }

    /**
     * Remove actualites
     *
     * @param \GestionProjetBundle\Entity\Actualite $actualites
     */
    public function removeActualite(\GestionProjetBundle\Entity\Actualite $actualites) {
        $this->actualites->removeElement($actualites);
    }

    /**
     * Get actualites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActualites() {
        return $this->actualites;
    }

    /**
     * Add message
     *
     * @param \GestionProjetBundle\Entity\Message $message
     * @return Utilisateur
     */
    public function addMessage(\GestionProjetBundle\Entity\Message $message) {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \GestionProjetBundle\Entity\Message $message
     */
    public function removeMessage(\GestionProjetBundle\Entity\Message $message) {
        $this->messages->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessage() {
        return $this->messages;
    }

    /**
     * Add messagemetadata
     *
     * @param \GestionProjetBundle\Entity\MessageMetadata $messagemetadata
     * @return Utilisateur
     */
    public function addMessagemetadatum(\GestionProjetBundle\Entity\MessageMetadata $messagemetadata) {
        $this->messagemetadata[] = $messagemetadata;

        return $this;
    }

    /**
     * Remove messagemetadata
     *
     * @param \GestionProjetBundle\Entity\MessageMetadata $messagemetadata
     */
    public function removeMessagemetadatum(\GestionProjetBundle\Entity\MessageMetadata $messagemetadata) {
        $this->messagemetadata->removeElement($messagemetadata);
    }

    /**
     * Get messagemetadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessagemetadata() {
        return $this->messagemetadata;
    }

    /**
     * Add threadmetadata
     *
     * @param \GestionProjetBundle\Entity\ThreadMetadata $threadmetadata
     * @return Utilisateur
     */
    public function addThreadmetadatum(\GestionProjetBundle\Entity\ThreadMetadata $threadmetadata) {
        $this->threadmetadata[] = $threadmetadata;

        return $this;
    }

    /**
     * Remove threadmetadata
     *
     * @param \GestionProjetBundle\Entity\ThreadMetadata $threadmetadata
     */
    public function removeThreadmetadatum(\GestionProjetBundle\Entity\ThreadMetadata $threadmetadata) {
        $this->threadmetadata->removeElement($threadmetadata);
    }

    /**
     * Get threadmetadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThreadmetadata() {
        return $this->threadmetadata;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Utilisateur
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param UploadedFile $file
     * @return object
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get the file used for profile picture uploads
     * 
     * @return UploadedFile
     */
    public function getFile() {

        return $this->file;
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../web/uploads/profils';
    }

    /**
     * @ORM\PrePersist() 
     * @ORM\PreUpdate() 
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * Generates a 32 char long random filename
     * 
     * @return string
     */
    public function generateRandomProfilePictureFilename() {
        $count = 0;
        do {
            $generator = new SecureRandom();
            $random = $generator->nextBytes(16);
            $randomString = bin2hex($random);
            $count++;
        } while (file_exists($this->getUploadRootDir() . '/' . $randomString . '.' . $this->getFile()->guessExtension()) && $count < 50);

        return $randomString;
    }

    /**
     * @ORM\PostPersist() 
     * @ORM\PostUpdate() 
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            //unlink($this->getUploadRootDir().'/'.$this->temp);
            //ou je renomme
            rename($this->getUploadRootDir() . '/' . $this->temp, $this->getUploadRootDir() . '/old' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

}
