<?php
// src/Cva/GestionMembreBundle/Entity/Etudiant.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Etudiant")
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
     */
    protected $birthday;
	
	/**
     * @ORM\Column(type="string", length=40, unique=true)
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
        return $this->civilite;
    }

    /**
     * Set paiement
     *
     * @param \Cva\GestionMembreBundle\Entity\Paiement $paiement
     * @return Etudiant
     */
    public function setPaiement(\Cva\GestionMembreBundle\Entity\Paiement $paiement = null)
    {
        $this->paiement = $paiement;
    
        return $this;
    }

    /**
     * Get paiement
     *
     * @return \Cva\GestionMembreBundle\Entity\Paiement 
     */
    public function getPaiement()
    {
        return $this->paiement;
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
}
