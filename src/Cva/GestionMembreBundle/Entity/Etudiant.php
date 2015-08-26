<?php
// src/Cva/GestionMembreBundle/Entity/Etudiant.php
namespace Cva\GestionMembreBundle\Entity;

use BdE\WeiBundle\Entity\Bungalow;
use BdE\WeiBundle\Entity\Bus;
use BdE\WeiBundle\Entity\Waiting;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cva\GestionMembreBundle\Entity\EtudiantRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table
 */
class Etudiant
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
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;
	
	/**
     * @ORM\Column(type="string", length=25)
     */
    protected $annee;
	
	/**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $departement;
	
	/**
     * @ORM\Column(type="string", unique=true, unique=true, nullable=true)
     */
    protected $numEtudiant;
	
	/**
     * @ORM\Column(type="date")
     * @var DateTime
     */
    protected $birthday;
	
	/**
     * @ORM\Column(type="string", length=250, unique=false)
     */
    protected $mail;
	
	/**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $tel;
	
	/**
     * @ORM\Column(type="string", length=10)
     */
    protected $civilite;
	
	/**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $remarque;

    /**
     * @ORM\OneToMany(targetEntity="Cva\GestionMembreBundle\Entity\Payment", mappedBy="student")
     */
    protected $payments;

    /**
     * @ORM\ManyToOne(targetEntity="BdE\WeiBundle\Entity\Bungalow", inversedBy="students")
     * @var Bungalow
     */
    protected $bungalow;

    /**
     * @ORM\ManyToOne(targetEntity="BdE\WeiBundle\Entity\Bus", inversedBy="students")
     * @var Bus
     */
    protected $bus;

    /**
     * @ORM\OneToMany(targetEntity="BdE\WeiBundle\Entity\Waiting", mappedBy="student")
     * @var Waiting
     */
    protected $waiting;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateModification;


    /**
     * @ORM\PrePersist
     */
    public function setCreationDateValue()
    {
        $this->dateModification = new \DateTime();
        $this->dateCreation = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setModificationDateValue()
    {
        $this->dateModification = new \DateTime();
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
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
		
		return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Etudiant
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Etudiant
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set numEtudiant
     *
     * @param integer $numEtudiant
     * @return Etudiant
     */
    public function setNumEtudiant($numEtudiant)
    {
        $this->numEtudiant = $numEtudiant;
    
        return $this;
    }

    /**
     * Get numEtudiant
     *
     * @return integer 
     */
    public function getNumEtudiant()
    {
        return $this->numEtudiant;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Etudiant
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Etudiant
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Etudiant
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }



  

    /**
     * Set civilite
     *
     * @param string $civilite
     * @return Etudiant
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    
        return $this;
    }

    /**
     * Get civilite
     *
     * @return string 
     */
    public function getCivilite()
    {
        switch($this->civilite){
            case 'Mme':
                return 'F';
            default:
                return $this->civilite;
        }
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     * @return Etudiant
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;
    
        return $this;
    }

    /**
     * Get remarque
     *
     * @return string 
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set annee
     *
     * @param string $annee
     * @return Etudiant
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    
        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set departement
     *
     * @param string $departement
     * @return Etudiant
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    
        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Etudiant
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return Etudiant
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    
        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    public function __toString()
    {
        return strtoupper($this->name)." ".$this->firstName;
    }

    /**
     * @return Payment
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    public function hasBungalow()
    {
    }

    /**
     * @return Bungalow
     */
    public function getBungalow()
    {
        return $this->bungalow;
    }

    /**
     * @param Bungalow $bungalow
     */
    public function setBungalow($bungalow)
    {
        $this->bungalow = $bungalow;
    }

    /**
     * @return Bus
     */
    public function getBus()
    {
        return $this->bus;
    }

    /**
     * @param Bus $bus
     */
    public function setBus($bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return Waiting
     */
    public function getWaiting()
    {
        return $this->waiting;
    }

    /**
     * @param Waiting $waiting
     */
    public function setWaiting($waiting)
    {
        $this->waiting = $waiting;
    }

    public function isMajeur(){
        return $this->birthday->diff(new \DateTime())->y >= 18;
    }

    /**
     * @return Produit[]
     */
    public function getProducts()
    {
        // Select only product which has not be bought by this student
        $boughtProducts = array();
        /** @var Payment[] $payments */
        $payments = $this->getPayments();
        foreach ($payments as $payment) {
            $boughtProducts[] = $payment->getProduct();
        }
        return $boughtProducts;
    }
}