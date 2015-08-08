<?php
namespace BdE\WeiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Cva\GestionMembreBundle\Entity\Etudiant;
use BdE\WeiBundle\Entity\Bus;
use BdE\WeiBundle\Entity\Bungalow;

/**
 * @ORM\Entity
 * @ORM\Table(name="DetailsWEI")
 */
class DetailsWEI
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	 /**
     * @ORM\OneToOne(targetEntity="Cva\GestionMembreBundle\Entity\Etudiant")
     */
    private $idEtudiant;
	

	/**
     * @ORM\ManyToOne(targetEntity="Bus")
     * @ORM\JoinColumn(name="bus_id", referencedColumnName="id", nullable=true)
     */
    protected $bus;

	/**
     * @ORM\ManyToOne(targetEntity="Bungalow")
     * @ORM\JoinColumn(name="bungalow_id", referencedColumnName="id", nullable=true)
     */
    protected $bungalow;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $placeListeAttente;



    // public function __toString()
    // {
    //     return 'test';
    // }

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
     * Set idEtudiant
     *
     * @param \Cva\GestionMembreBundle\Entity\Etudiant $idEtudiant
     * @return DetailsWEI
     */
    public function setIdEtudiant(\Cva\GestionMembreBundle\Entity\Etudiant $idEtudiant = null)
    {
        $this->idEtudiant = $idEtudiant;
    
        return $this;
    }

    /**
     * Get idEtudiant
     *
     * @return \Cva\GestionMembreBundle\Entity\Etudiant 
     */
    public function getIdEtudiant()
    {
        return $this->idEtudiant;
    }

    /**
     * Set bus
     *
     * @param \Cva\GestionMembreBundle\Entity\Bus $bus
     * @return DetailsWEI
     */
    public function setBus(\Cva\GestionMembreBundle\Entity\Bus $bus = null)
    {
        $this->bus = $bus;
    
        return $this;
    }

    /**
     * Get bus
     *
     * @return \Cva\GestionMembreBundle\Entity\Bus 
     */
    public function getBus()
    {
        return $this->bus;
    }

    /**
     * Set bungalow
     *
     * @param \Cva\GestionMembreBundle\Entity\Bungalow $bungalow
     * @return DetailsWEI
     */
    public function setBungalow(\Cva\GestionMembreBundle\Entity\Bungalow $bungalow = null)
    {
        $this->bungalow = $bungalow;
    
        return $this;
    }

    /**
     * Get bungalow
     *
     * @return \Cva\GestionMembreBundle\Entity\Bungalow 
     */
    public function getBungalow()
    {
        return $this->bungalow;
    }

    /**
     * Set placeListeAttente
     *
     * @param integer $placeListeAttente
     * @return DetailsWEI
     */
    public function setPlaceListeAttente($placeListeAttente)
    {
        $this->placeListeAttente = $placeListeAttente;
    
        return $this;
    }

    /**
     * Get placeListeAttente
     *
     * @return integer 
     */
    public function getPlaceListeAttente()
    {
        return $this->placeListeAttente;
    }
}