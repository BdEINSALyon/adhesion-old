<?php

namespace BdE\MainBundle\Entity;

use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mail
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="BdE\MainBundle\Entity\MailRepository")
 */
class Mail
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, unique=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_of_conditions", type="smallint")
     */
    private $nbOfConditions;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Cva\GestionMembreBundle\Entity\Produit")
     * @ORM\JoinTable(name="mails_for_products",
     *      joinColumns={@ORM\JoinColumn(name="mail_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $forProducts;

    /**
     * @var string[]
     * @ORM\Column(name="for_years", type="array", nullable=true)
     */
    private $forYears;

    /**
     * @var string[]
     * @ORM\Column(name="for_department", type="array", nullable=true)
     */
    private $forDepartment;

    /**
     * @var integer
     *
     * @ORM\Column(name="for_new_members", type="smallint")
     */
    private $forNewMembers;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->forDepartment = [];
        $this->forProducts = new ArrayCollection();
        $this->forYears = [];
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateNbOfConditions(){
        $nb = 0;
        if(count($this->forYears)>0){
            $nb++;
        }
        if(count($this->forDepartment)>0){
            $nb++;
        }
        if($this->forProducts->count()>0){
            $nb++;
        }
        if($this->forNewMembers != 0){
            $nb++;
        }
        $this->nbOfConditions = $nb;

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
     * Set name
     *
     * @param string $name
     *
     * @return Mail
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
     * Set content
     *
     * @param string $content
     *
     * @return Mail
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Mail
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Mail
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return ArrayCollection
     */
    public function getForProducts()
    {
        return $this->forProducts;
    }

    /**
     * @return ArrayCollection
     */
    public function getForYears()
    {
        return $this->forYears;
    }

    /**
     * @return ArrayCollection
     */
    public function getForDepartment()
    {
        return $this->forDepartment;
    }

    /**
     * @param \string[] $forYears
     */
    public function setForYears($forYears)
    {
        $this->forYears = $forYears;
    }

    /**
     * @param \string[] $forDepartment
     */
    public function setForDepartment($forDepartment)
    {
        $this->forDepartment = $forDepartment;
    }


    /**
     * Match if this mail can be send to this user.
     * @param Etudiant $student The student to test for this mail
     * @param Produit[] $addProducts
     * @return true if it can be used to send a mail
     */
    public function canBeSentTo(Etudiant $student, array $addProducts = []){

        if(!$this->active) return false;

        // Check creation date
        switch($this->getForNewMembers()){
            case 1:
                if($student->getDateCreation() < new \DateTime("3 months ago"))
                    return false;
                break;
            case 2:
                if($student->getDateCreation() >= new \DateTime("3 months ago"))
                    return false;
                break;
            case 0:
            default:
        }

        // Check if this is good year
        $valid = count($this->forYears) == 0; // Already valid if no condition
        foreach($this->forYears as $year)
            if(strval($student->getAnnee()) == strval($year))
                $valid = true;
        if(!$valid) return false;

        // Check department
        $valid = count($this->forDepartment) == 0; // Already valid if no condition
        foreach($this->forDepartment as $department)
            if(strval($student->getDepartement()) == strval($department))
                $valid = true;
        if(!$valid) return false;

        // Check products
        $valid = $this->forProducts->count() == 0; // Already valid if no condition
        $sum = 0;
        $produits = array_merge($student->getProducts(), $addProducts);
        foreach($this->forProducts as $product) {
            foreach($produits as $boughtProduct)
                if($product == $boughtProduct)
                    $sum++;
        }
        if($sum == $this->forProducts->count())
            $valid = true;
        if(!$valid) return false;

        return true;
    }

    /**
     * @return int 0 is for disabled, 1 means only for new members and 2 means only for old members
     */
    public function getForNewMembers()
    {
        return $this->forNewMembers;
    }

    /**
     * @param int $forNewMembers 0 is for disabled, 1 means only for new members and 2 means only for old members
     */
    public function setForNewMembers($forNewMembers)
    {
        $this->forNewMembers = $forNewMembers;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
}

