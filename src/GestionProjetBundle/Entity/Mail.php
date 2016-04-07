<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity
 */
class Mail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMail", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idmail;

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
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="mails")
     * @ORM\JoinTable(name="mail_utilisateur",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idMail", referencedColumnName="idMail")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id", referencedColumnName="id")
     *   }
     * )
     */
    private $utilisateurs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idmail
     *
     * @return integer 
     */
    public function getIdmail()
    {
        return $this->idmail;
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
     * @param \GestionProjetBundle\Entity\Utilisateur $utilisateur
     * @return Mail
     */
    public function addUtilisateur(\GestionProjetBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \GestionProjetBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\GestionProjetBundle\Entity\Utilisateur $utilisateur)
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
}
