<?php
// src/Cva/GestionMembreBundle/Entity/Paiement.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Produit;

/**
 * @ORM\Entity
 * @ORM\Table(name="Paiement")
 */
class Paiement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	 /**
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id", nullable=false)
     */
    private $idEtudiant;
	
	/**
     * @ORM\Column(type="datetime")
     */
    protected $dateAchat;
	
	/**
     * @ORM\ManyToMany(targetEntity="Produit")
     * @ORM\JoinTable(name="paiement_produits",
     *      joinColumns={@ORM\JoinColumn(name="paiement_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="produit_id", referencedColumnName="id")}
     *      )
     **/
    private $produits;

    /**
     * @ORM\Column(type="text")
     */
    protected $moyenPaiement;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add produits
     *
     * @param \Cva\GestionMembreBundle\Entity\Produit $produits
     * @return Paiement
     */
    public function addProduit(\Cva\GestionMembreBundle\Entity\Produit $produits)
    {
        $this->produits[] = $produits;
    
        return $this;
    }

    /**
     * Remove produits
     *
     * @param \Cva\GestionMembreBundle\Entity\Produit $produits
     */
    public function removeProduit(\Cva\GestionMembreBundle\Entity\Produit $produits)
    {
        $this->produits->removeElement($produits);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set idEtudiant
     *
     * @param \Cva\GestionMembreBundle\Entity\Etudiant $idEtudiant
     * @return Paiement
     */
    public function setIdEtudiant(\Cva\GestionMembreBundle\Entity\Etudiant $idEtudiant)
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
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     * @return Paiement
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;
    
        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime 
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    public function setUpdated()
    {
        $this->dateAchat = new \DateTime("now");
    }

    /**
     * Set moyenPaiement
     *
     * @param string $moyenPaiement
     * @return Paiement
     */
    public function setMoyenPaiement($moyenPaiement)
    {
        $this->moyenPaiement = $moyenPaiement;
    
        return $this;
    }

    /**
     * Get moyenPaiement
     *
     * @return string 
     */
    public function getMoyenPaiement()
    {
        return $this->moyenPaiement;
    }
}
