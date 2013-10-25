<?php
// src/Cva/GestionMembreBundle/Entity/Produit.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Produit")
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $description;

	/**
     * @ORM\Column(type="string", length=10)
     */
    protected $disponibilite;
	
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
     * Set price
     *
     * @param float $price
     * @return Produit
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Produit
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
     * Set disponibilite
     *
     * @param string $disponibilite
     * @return Produit
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    
        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return string 
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }
}