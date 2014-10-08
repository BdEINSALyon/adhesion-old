<?php

namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bungalow
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cva\GestionMembreBundle\Entity\BungalowRepository")
 */
class Bungalow
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=2, nullable=true)
     */
    private $sexe;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     */
    private $nbPlaces;


    public function __toString()
    {
        return $this->nom;
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
     * @return Bungalow
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
     * Set sexe
     *
     * @param string $sexe
     * @return Bungalow
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Bungalow
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;
    
        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return integer 
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

}