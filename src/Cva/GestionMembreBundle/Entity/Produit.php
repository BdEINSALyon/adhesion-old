<?php
// src/Cva/GestionMembreBundle/Entity/Produit.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
	
	/**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $price;
	
	/**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

	/**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Paiement", mappedBy="produits")
     */
    protected $paiements;

    /**
     * @ORM\OneToMany(targetEntity="Cva\GestionMembreBundle\Entity\Payment", mappedBy="product")
     */
    protected $payments;
	
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Produit
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Produit
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return Produit
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }



    public function __toString()
    {
        return $this->name." - ".$this->price."€";
    }
}