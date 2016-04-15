<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Courier
 *
 * @ORM\Table(name="courier")
 * @ORM\Entity(repositoryClass="GestionProjetBundle\Repository\CourierRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Courier
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=255, nullable=true)
     */
    private $objet;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=false)
     */
    private $contenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var \Intervenant
     *
     * @ORM\ManyToOne(targetEntity="Intervenant", inversedBy="couriers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="emetteur", referencedColumnName="id")
     * })
     */
    private $emetteur;
    
    /**
     * @var \Courier 
     * @ORM\OneToOne(targetEntity="Courier")
     * @ORM\JoinColumn(name="courierreference", referencedColumnName="id")
     */
    private $courierreference;

    /**
    * @ORM\OneToMany(targetEntity="Courierenvoye", mappedBy="idcourier", cascade={"remove", "persist"})
    */
    private $courierenvoyes;
    
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
    * @var array
    */
    private $uploadedFiles;
    
    /**
     * Constructor
     */
    public function __construct(){
        $this->courierenvoyes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->piecesjointes = array();
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
     * Set type
     *
     * @param integer $type
     * @return Courier
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
     * Set date
     *
     * @param \DateTime $date
     * @return Courier
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
     * Set objet
     *
     * @param string $objet
     * @return Courier
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
     * Set reference
     *
     * @param string $reference
     * @return Courier
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set emetteur
     *
     * @param \GestionProjetBundle\Entity\Intervenant $emetteur
     * @return Courier
     */
    public function setEmetteur(\GestionProjetBundle\Entity\Intervenant $emetteur = null)
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return \GestionProjetBundle\Entity\Intervenant 
     */
    public function getEmetteur()
    {
        return $this->emetteur;
    }
    
    /**
     * Set courirereference
     *
     * @param \GestionProjetBundle\Entity\Courier $courirereference
     * @return Courier
     */
    public function setCourierreference(\GestionProjetBundle\Entity\Courier $courirereference = null)
    {
        $this->courierreference = $courirereference;

        return $this;
    }

    /**
     * Get courirereference
     *
     * @return \GestionProjetBundle\Entity\Courier 
     */
    public function getCourierreference()
    {
        return $this->courierreference;
    }
    
    /**
     * Add courierenvoye
     *
     * @param GestionProjetBundle\Entity\Courierenvoye $courierenvoye 
     * @return Courier
     */
    public function addCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoye)
    {
        $this->courierenvoyes[] = $courierenvoye;
        return $this;
    }
    
    /**
     * Get courierenvoyes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourierenvoyes()
    {
        return $this->courierenvoyes;
    }
    
    /**
     * Set courierenvoyes
     *
     * @param \Doctrine\Common\Collections\Collection $courierenvoyes
     * @return Courier
     */
    public function setCourierenvoyes(\Doctrine\Common\Collections\Collection $courierenvoyes = null)
    {
        $this->courierenvoyes = $courierenvoyes;

        return $this;
    }
    

    /**
     * Remove courierenvoyes
     *
     * @param \GestionProjetBundle\Entity\Courierenvoye $courierenvoyes
     */
    public function removeCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoyes)
    {
        $this->courierenvoyes->removeElement($courierenvoyes);
        
    }
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Courier
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
     * Set contenu
     *
     * @param string $contenu
     * @return Courier
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
        foreach($this->uploadedFiles as $file)
        {
            $path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
            array_push ($this->piecesjointes, $path);
            $file->move($this->getUploadRootDir(), $path);
            unset($file);
        }
        unset($this->uploadedFiles);
    } 
    
    
   
}
