<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="GestionProjetBundle\Repository\MailRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Mail
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
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Utilisateur")
     */
    private $emetteur ;
	
	/**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinataire", referencedColumnName="id", nullable=true)
     * })
     */
    private $destinataire;
	
    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=true)
     */
    private $contenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\UserBundle\Entity\Utilisateur", inversedBy="mails")
     * @ORM\JoinTable(name="mail_utilisateur",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idMail", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id", referencedColumnName="id")
     *   }
     * )
     */
    private $utilisateurs;
	
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
    * @ORM\Column(type="array", nullable=true)
    */
    private $piecesjointes;
    
    /**
    * @ORM\Column(type="array", nullable=true)
    */
    private $originalpiecesjointes;
	
	/**
    * @var array
    */
    private $uploadedFiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
		$this->piecesjointes = array();
        $this->originalpiecesjointes = array();
        $this->date = new \Datetime();
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
     * Set objet
     *
     * @param string $objet
     * @return Mail
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string 
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Mail
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Mail
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
     * Set type
     *
     * @param integer $type
     * @return Mail
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Mail
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
     * Add utilisateur
     *
     * @param \UserBundle\Entity\Utilisateur $utilisateur
     * @return Mail
     */
    public function addUtilisateur(\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \UserBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs->removeElement($utilisateur);
    }

    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }
    
    /**
     * Set utilisateurs
     *
     * @param \Doctrine\Common\Collections\Collection $utilisateurs
     * @return Mail
     */
    public function setUtilisateurs(\Doctrine\Common\Collections\Collection $utilisateurs = null)
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    /**
     * Set emetteur
     *
     * @param \UserBundle\Entity\Utilisateur $emetteur
     * @return Mail
     */
    public function setEmetteur(\UserBundle\Entity\Utilisateur $emetteur = null)
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return \UserBundle\Entity\Utilisateur 
     */
    public function getEmetteur()
    {
        return $this->emetteur;
    }
	
	/**
     * Set destinataire
     *
     * @param \UserBundle\Entity\Utilisateur $destinataire
     * @return Mail
     */
    public function setDestinataire(\UserBundle\Entity\Utilisateur $destinataire = null)
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * Get destinataire
     *
     * @return \UserBundle\Entity\Utilisateur 
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }
	
	/**
     * Set path
     *
     * @param string $path
     * @return Ressource
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set piecesjointes
     *
     * @param string $piecesjointes
     * @return Ressource
     */
    public function setPiecesjointes($piecesjointes)
    {
        $this->piecesjointes = $piecesjointes;

        return $this;
    }

    /**
     * Get piecesjointes
     *
     * @return array 
     */
    public function getPiecesjointes()
    {
        return $this->piecesjointes;
    }
    
    /**
     * Set originalpiecesjointes
     *
     * @param string $originalpiecesjointes
     * @return Ressource
     */
    public function setOriginalpiecesjointes($originalpiecesjointes)
    {
        $this->originalpiecesjointes = $originalpiecesjointes;

        return $this;
    }

    /**
     * Get originalpiecesjointes
     *
     * @return array 
     */
    public function getOriginalpiecesjointes()
    {
        return $this->originalpiecesjointes;
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
        return __DIR__ . '/../../../web/uploads/couriers';
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
        $info = pathinfo($this->getFile()->getClientOriginalName());
        $file_name =  basename($this->getFile()->getClientOriginalName(),'.'.$info['extension']);
        $this->setReference($file_name);
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
    
    /**
     * Sets uploadedFiles.
     *
     * @param array $uploadedFiles
     */
    public function setUploadedFiles(array $uploadedFiles = null)
    {
        $this->uploadedFiles = $uploadedFiles;
    }

    /**
     * Get uploadedFiles.
     *
     * @return array
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
    
    /**
    * @ORM\PreFlush()
    */
    public function uploadPiecesjointes()
    {
        if($this->uploadedFiles){
            $this->piecesjointes= array();
            $this->originalpiecesjointes= array();
            foreach($this->uploadedFiles as $file)
            {
                $info = pathinfo($file->getClientOriginalName());
                $file_name =  basename($file->getClientOriginalName(),'.'.$info['extension']);
                array_push($this->originalpiecesjointes, $file_name);
                $path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
                array_push ($this->piecesjointes, $path);
                $file->move($this->getUploadRootDir(), $path);
                unset($file);
            }
        }
        
        $this->uploadedFiles=array();
    } 
	
}
