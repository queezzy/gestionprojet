<?php

namespace GestionProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="calendrier", indexes={@ORM\Index(name="fk_Calendrier_Intervenant1_idx", columns={"idIntervenant"})})
 * @ORM\Entity
 */
class Calendrier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCalendrier", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcalendrier;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

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
     * Get idcalendrier
     *
     * @return integer 
     */
    public function getIdcalendrier()
    {
        return $this->idcalendrier;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Calendrier
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set idintervenant
     *
     * @param \GestionProjetBundle\Entity\Intervenant $idintervenant
     * @return Calendrier
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
}
