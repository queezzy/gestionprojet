<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Intervenant
 *
 * @ORM\Table(name="intervenant")
 * @ORM\Entity(repositoryClass="GestionProjetBundle\Repository\IntervenantRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Intervenant
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
     * @ORM\Column(type="string", length=255, nullable=true) 
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000") 
     */
    private $file;
    
    private $temp;
    
    /**
     * @var \Adresse 
     * @ORM\OneToOne(targetEntity="Adresse",cascade={"persist"})
     * @ORM\JoinColumn(name="idAdresse", referencedColumnName="id")
     */
    private $idadresse;

    /**
     * @var \Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="intervenants")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLot", referencedColumnName="id")
     * })
     */
    private $idlot;

    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Projet", mappedBy="intervenants")
     */
    private $projets;
    /**
    * @ORM\OneToMany(targetEntity="Courierenvoye", mappedBy="idintervenant", cascade={"remove", "persist"})
    */
    private $courierenvoyes;
    
    /**
    * @ORM\OneToMany(targetEntity="\UserBundle\Entity\Utilisateur", mappedBy="idintervenant", cascade={"remove", "persist"})
    */
    private $utilisateurs;
    
    /**
    * @ORM\OneToMany(targetEntity="Ressource", mappedBy="idintervenant", cascade={"remove", "persist"})
    */
    private $ressources;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courierenvoyes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ressources = new \Doctrine\Common\Collections\ArrayCollection();
		$this->projets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evolutionattendu = 0;
        $this->evolutionencours = 0;
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
     * Add courierenvoye
     *
     * @param GestionProjetBundle\Entity\Courierenvoye $courierenvoye 
     * @return Intervenant
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
     * @return Intervenant
     */
    public function setCourierenvoyes(\Doctrine\Common\Collections\Collection $courierenvoyes = null)
    {
        $this->courierenvoyes = $courierenvoyes;

        return $this;
    }
    
    /**
     * Add utilisateur
     *
     * @param UserBundle\Entity\Utilisateur $utilisateur 
     * @return Intervenant
     */
    public function addUtilisateur(\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;
        return $this;
    }
    
    /**
     * Get utilisateurs
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
     * @return Intervenant
     */
    public function setUtilisateurs(\Doctrine\Common\Collections\Collection $utilisateurs = null)
    {
        $this->utilisateurs = $utilisateurs;

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
     * Remove utilisateur
     *
     * @param \UserBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs->removeElement($utilisateur);
    }
    /**
     * Get ressources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRessources()
    {
        return $this->ressources;
    }
    
    /**
     * Set ressources
     *
     * @param \Doctrine\Common\Collections\Collection $ressources
     * @return Intervenant
     */
    public function setRessources(\Doctrine\Common\Collections\Collection $ressources = null)
    {
        $this->ressources = $ressources;

        return $this;
    }
    
    
    /**
     * Add ressources
     *
     * @param \GestionProjetBundle\Entity\Ressource $ressources
     * @return Intervenant
     */
    public function addRessource(\GestionProjetBundle\Entity\Ressource $ressources)
    {
        $this->ressources[] = $ressources;

        return $this;
    }

    /**
     * Remove ressources
     *
     * @param \GestionProjetBundle\Entity\Ressource $ressources
     */
    public function removeRessource(\GestionProjetBundle\Entity\Ressource $ressources)
    {
        $this->ressources->removeElement($ressources);
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
        return __DIR__ . '/../../../web/uploads/intervenants';
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
     * Add projet
     *
     * @param \GestionProjetBundle\Entity\Projet $projet
     * @return Intervenant
     */
    public function addProjet(\GestionProjetBundle\Entity\Projet $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     *
     * @param \GestionProjetBundle\Entity\Projet $projet
	 * @return Intervenant
     */
    public function removeProjet(\GestionProjetBundle\Entity\Projet $projet)
    {
        $this->projets->removeElement($projet);
		return $this;
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjets()
    {
        return $this->projets;
    }
    
    
    /**
     * Set projets
     *
     * @param \Doctrine\Common\Collections\Collection $projets
     * @return Intervenant
     */
    public function setProjets(\Doctrine\Common\Collections\Collection $projets = null)
    {
        $this->projets = $projets;

        return $this;
    }

}
