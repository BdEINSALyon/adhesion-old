<?php

namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cva\GestionMembreBundle\Entity\PaymentRepository")
 */
class Payment
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
     * This must be an uuid used to identify product bought together.
     *
     * @var string
     *
     * @ORM\Column(name="bill_id", type="string", length=36)
     */
    private $billId;

    /**
     * @var Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Cva\GestionMembreBundle\Entity\Etudiant", inversedBy="payments")
     * @ORM\JoinColumn(name="student_id",referencedColumnName="id")
     */
    private $student;

    /**
     * @var Produit
     *
     * @ORM\ManyToOne(targetEntity="Cva\GestionMembreBundle\Entity\Produit", inversedBy="payments")
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id")
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=3)
     */
    private $method;

    /**
     * @return Produit
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Produit $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return Etudiant
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Etudiant $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
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
     * Set billId
     *
     * @param string $billId
     *
     * @return Payment
     */
    public function setBillId($billId)
    {
        $this->billId = $billId;

        return $this;
    }

    /**
     * Get billId
     *
     * @return string
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Payment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Payment
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}

