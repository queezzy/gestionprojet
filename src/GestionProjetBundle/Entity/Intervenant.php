<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\GeneratedValue(strategy="AUTO")
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
    * @var \Symfony\Component\HttpFoundation\File\UploadedFile
    * @Assert\File(maxSize="2M")
    */
    public $file;
    
    /**
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     * @var \Adresse
     *
     * @ORM\OneToOne(targetEntity="Adresse",cascade={"persist"})
     
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
    * @ORM\OneToMany(targetEntity="Calendrier", mappedBy="idintervenant", cascade={"remove", "persist"})
    */
    private $calendriers;
    
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
     * @<ORM\OneToOne(targetEntity="Calendrier",cascade={"persist"})
     */
    private $idcalendrier ;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->calendriers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courierenvoyes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ressources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add calendrier
     *
     * @param GestionProjetBundle\Entity\Calendrier $calendrier 
     * @return Intervenant
     */
    public function addCalendrier(\GestionProjetBundle\Entity\Calendrier $calendrier)
    {
        $this->calendriers[] = $calendrier;
        return $this;
    }
    
    /**
     * Get calendriers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendriers()
    {
        return $this->calendriers;
    }
    
    /**
     * Set calendriers
     *
     * @param \Doctrine\Common\Collections\Collection $calendriers
     * @return Intervenant
     */
    public function setCalendriers(\Doctrine\Common\Collections\Collection $calendriers = null)
    {
        $this->calendriers = $calendriers;

        return $this;
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
     * @param GestionProjetBundle\Entity\Utilisateur $utilisateur 
     * @return Intervenant
     */
    public function addUtilisateur(\GestionProjetBundle\Entity\Utilisateur $utilisateur)
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
     * Remove calendriers
     *
     * @param \GestionProjetBundle\Entity\Calendrier $calendriers
     */
    public function removeCalendrier(\GestionProjetBundle\Entity\Calendrier $calendriers)
    {
        $this->calendriers->removeElement($calendriers);
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
     * Remove utilisateurs
     *
     * @param \GestionProjetBundle\Entity\Utilisateur $utilisateurs
     */
    public function removeUtilisateur(\GestionProjetBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs->removeElement($utilisateurs);
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
    
    function getFile() {
        return $this->file;
    }

    function getUrl() {
        return $this->url;
    }

    function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file) {
        $this->file = $file;
    }

    function setUrl($url) {
        $this->url = $url;
    }


    public function upload(){
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->url = $this->file->getClientOriginalName();
        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }
    public function getAbsoluteUrl(){
        return null === $this->url ? null : $this->getUploadRootDir().'/'.$this->url;
    }
    public function getWebUrl(){
        return null === $this->url ? null : $this->getUploadDir().'/'.$this->url;
    }
    protected function getUploadRootDir(){
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/imagesintervenants';
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
}
