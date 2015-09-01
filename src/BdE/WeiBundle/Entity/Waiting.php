<?php

namespace BdE\WeiBundle\Entity;

use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;

/**
 * Waiting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BdE\WeiBundle\Entity\WaitingRepository")
 */
class Waiting
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
     * @var Etudiant
     * @ORM\ManyToOne(targetEntity="Cva\GestionMembreBundle\Entity\Etudiant", inversedBy="waiting")
     */
    private $student;

    /**
     * @var Payment
     * @ORM\ManyToOne(targetEntity="Cva\GestionMembreBundle\Entity\Payment")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     */
    private $payment;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;


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
     * Set rank
     *
     * @param integer $rank
     *
     * @return Waiting
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Waiting
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Etudiant $student
     * @return Waiting
     */
    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return Etudiant
     */
    public function getStudent()
    {
        return $this->student;
    }

    public function setPayment($product)
    {
        $this->payment = $product;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }



}

