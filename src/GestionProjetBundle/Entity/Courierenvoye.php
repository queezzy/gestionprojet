<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courierenvoye
 *
 * @ORM\Table(name="courierenvoye", uniqueConstraints={@ORM\UniqueConstraint(name="CourierEnvoye_UNIQUE", columns={"idIntervenant", "idRessource", "idCourier"})}, indexes={@ORM\Index(name="fk_CourierEnvoye_Intervenant1_idx", columns={"idIntervenant"}), @ORM\Index(name="fk_CourierEnvoye_Ressource1_idx", columns={"idRessource"}), @ORM\Index(name="fk_CourierEnvoye_Courier1_idx", columns={"idCourier"})})
 * @ORM\Entity
 */
class Courierenvoye
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCourierEnvoye", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idcourierenvoye;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var \Courier
     *
     * @ORM\ManyToOne(targetEntity="Courier", inversedBy="courierenvoyes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCourier", referencedColumnName="idCourier")
     * })
     */
    private $idcourier;

    /**
     * @var \Intervenant
     *
     * @ORM\ManyToOne(targetEntity="Intervenant", inversedBy="courierenvoyes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idIntervenant", referencedColumnName="idIntervenant")
     * })
     */
    private $idintervenant;

    /**
     * @var \Ressource
     *
     * @ORM\ManyToOne(targetEntity="Ressource", , inversedBy="courierenvoyes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRessource", referencedColumnName="idRessource")
     * })
     */
    private $idressource;



    /**
     * Get idcourierenvoye
     *
     * @return integer 
     */
    public function getIdcourierenvoye()
    {
        return $this->idcourierenvoye;
    }

    /**
     * Set idcourier
     *
     * @param \GestionProjetBundle\Entity\Courier $idcourier
     * @return Courierenvoye
     */
    public function setIdcourier(\GestionProjetBundle\Entity\Courier $idcourier = null)
    {
        $this->idcourier = $idcourier;

        return $this;
    }

    /**
     * Get idcourier
     *
     * @return \GestionProjetBundle\Entity\Courier 
     */
    public function getIdcourier()
    {
        return $this->idcourier;
    }

    /**
     * Set idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     * @return Courierenvoye
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
     * Set idressource
     *
     * @param \GestionProjetBundle\Entity\Ressource $idressource
     * @return Courierenvoye
     */
    public function setIdressource(\GestionProjetBundle\Entity\Ressource $idressource = null)
    {
        $this->idressource = $idressource;

        return $this;
    }

    /**
     * Get idressource
     *
     * @return \GestionProjetBundle\Entity\Ressource 
     */
    public function getIdressource()
    {
        return $this->idressource;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Courierenvoye
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
}
