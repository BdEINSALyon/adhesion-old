<?php

namespace BdE\WeiBundle\Entity;

use BdE\WeiBundle\Utils\Affectation;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bungalow
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BungalowRepository")
 */
class Bungalow
{
    const BOYS = "M";
    const GIRLS = "F";

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
     * @Assert\Choice(choices = {"M", "F"}, message = "La valeur doit être M ou F")
     */
    private $sexe;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     */
    private $nbPlaces;

    /**
     * Describe Etudiants who are affected in a Bungalow for the WEI
     *
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Etudiant")
     *
     * @ORM\JoinTable(
     *      name="etudiants_bungalow",
     *      joinColumns={@ORM\JoinColumn(name="bungalow_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="etudiant_id", referencedColumnName="id", unique = true)}
     * )
     */
    private $etudiants;

    /**
     * Bus constructor.
     */
    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

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


    /**
     * Fetch all Etudiants registred on this bungalow.
     * @return array A copy of the ArrayCollection of Etudiants.
     */
    public function getEtudiants(){
        return $this->etudiants->toArray();
    }

    /**
     * Add an Etudiant to this bungalow
     * @param Etudiant $etudiant The person to add
     * @return Affectation Result from this, see BdE\WeiBundle\Utils\Affectation
     */
    public function addEtudiant(Etudiant $etudiant){
        if(!$etudiant) return Affectation::Error;
        if($this->etudiants->contains($etudiant)) return Affectation::AlreadyIn;
        if($etudiant->hasBungalow()) return Affectation::AffectedToAnother;
        if($this->getNbPlaces()>=$this->getAmountOfRegisteredEtudiants()) return Affectation::Full;
        $this->etudiants->add($etudiant);
        return Affectation::OK;
    }

    /**
     * Remove an Etudiant from this bungalow
     * @param Etudiant $etudiant The person to add
     * @return Affectation Result from this, see BdE\WeiBundle\Utils\Affectation
     */
    public function removeEtudiant(Etudiant $etudiant){
        if(!$etudiant) return Affectation::Error;
        if(!$this->etudiants->contains($etudiant)) return Affectation::Error;
        $this->etudiants->remove($etudiant);
        return Affectation::OK;
    }

    /**
     * Count numbers of Etudiant registered in this bungalow.
     * @return integer Amount of registered Etudiants
     */
    public function getAmountOfRegisteredEtudiants(){
        return $this->etudiants->count();
    }

    /**
     * Determines if it can be deleted.
     *
     * @return boolean True if it could be deleted safely
     */
    public function canBeDeletedSafely(){
        return $this->getAmountOfRegisteredEtudiants() <= 0; // Inferior to 0 will be strange but we doesn't let as
        // a functional bug
    }

}