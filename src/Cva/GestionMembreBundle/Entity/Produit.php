<?php
// src/Cva/GestionMembreBundle/Entity/Produit.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cva\GestionMembreBundle\Entity\ProduitRepository")
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
     * @ORM\Column(type="boolean")
     */
    protected $hasWaitingList;

    /**
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Paiement", mappedBy="produits")
     */
    protected $paiements;

    /**
     * @ORM\OneToMany(targetEntity="Cva\GestionMembreBundle\Entity\Payment", mappedBy="product")
     */
    protected $payments;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Produit", inversedBy="wouldNotBeSoldWith")
     * @ORM\JoinTable(name="product_product_denies",
     *      joinColumns={@ORM\JoinColumn(name="product_sold", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_can_not_be_sold", referencedColumnName="id")}
     *      )
     */
    protected $canNotBeSoldWith;

    /**
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Produit", mappedBy="canNotBeSoldWith")
     */
    protected $wouldNotBeSoldWith;

    /**
     * Produit constructor.
     */
    public function __construct()
    {
        $this->canNotBeSoldWith = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getCanNotBeSoldWith()
    {
        return $this->canNotBeSoldWith;
    }

    /**
     * @param mixed $canNotBeSoldWith
     */
    public function addCanNotBeSoldWith($canNotBeSoldWith)
    {
        $this->canNotBeSoldWith->add($canNotBeSoldWith);
    }

    public function hasWaitingList()
    {
        return $this->hasWaitingList;
    }
}