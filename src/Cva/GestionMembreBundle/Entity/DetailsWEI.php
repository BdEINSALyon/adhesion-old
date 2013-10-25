<?php
// src/Cva/GestionMembreBundle/Entity/DetailsWEI.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Cva\GestionMembreBundle\Entity\Etudiant;

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
     * @ORM\OneToOne(targetEntity="Etudiant")
     */
    private $idEtudiant;
	
	/**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $bus;

	/**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $bungalow;
	

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
     * Set bus
     *
     * @param string $bus
     * @return DetailsWEI
     */
    public function setBus($bus)
    {
        $this->bus = $bus;
    
        return $this;
    }

    /**
     * Get bus
     *
     * @return string 
     */
    public function getBus()
    {
        return $this->bus;
    }

    /**
     * Set bungalow
     *
     * @param string $bungalow
     * @return DetailsWEI
     */
    public function setBungalow($bungalow)
    {
        $this->bungalow = $bungalow;
    
        return $this;
    }

    /**
     * Get bungalow
     *
     * @return string 
     */
    public function getBungalow()
    {
        return $this->bungalow;
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
}