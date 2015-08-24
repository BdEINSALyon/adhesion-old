<?php

namespace BdE\WeiBundle\Entity;

use BdE\WeiBundle\Utils\Affectation;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Bus Entity.
 * A Bus is something design to contains Etudiants but with a max gap specified by nbPlace. Its name is used because
 * humans need one to distinct buses.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BusRepository")
 * @Assert\Callback(methods={"checkNbPlacesIsMoreThanEtudiants"})
 */
class Bus
{
    /**
     * Because we need one ;-)
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * It's better to give it a human name.
     *
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * This is the max number of Etudiant that this bus should contains.
     *
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     */
    private $nbPlaces;

    /**
     * Describe Etudiants who are registered in a Bus for the WEI
     *
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Etudiant")
     * @ORM\JoinTable(
     *      name="etudiants_bus",
     *      joinColumns={@ORM\JoinColumn(name="bus_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="etudiant_id", referencedColumnName="id", unique=true )}
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
     * @return Bus
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
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Bus
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
     * Fetch all Etudiants registred on this bus.
     * @return array A copy of the ArrayCollection of Etudiants.
     */
    public function getEtudiants(){
        return $this->etudiants->toArray();
    }

    /**
     * Add an Etudiant to this Bus
     * @param Etudiant $etudiant The person to add
     * @return Affectation Result from this, see BdE\WeiBundle\Utils\Affectation
     */
    public function addEtudiant(Etudiant $etudiant){
        if(!$etudiant) return Affectation::Error;
        if($this->etudiants->contains($etudiant)) return Affectation::AlreadyIn;
        if($this->getNbPlaces()>=$this->getAmountOfRegisteredEtudiants()) return Affectation::Full;
        $this->etudiants->add($etudiant);
        return Affectation::OK;
    }

    /**
     * Remove an Etudiant from this Bus
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
     * Count numbers of Etudiant registered in this Bus.
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

    /**
     * @param ExecutionContextInterface $context
     */
    public function checkNbPlacesIsMoreThanEtudiants(ExecutionContextInterface $context){
        if($this->nbPlaces < 0){
            $context->buildViolation("Le bus ne peut pas avoir un nombre de place négatives")
                ->atPath("nbPlaces")
                ->addViolation();
        } elseif($this->nbPlaces < $this->getAmountOfRegisteredEtudiants()){
            $context->buildViolation("Il y a plus d'étudiants que de place dans ce bus, y a un 'blem là !")
                ->atPath("nbPlaces")
                ->addViolation();
        }
    }
}

