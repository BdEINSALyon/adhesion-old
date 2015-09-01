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
     * @param $student Etudiant
     * @param $product Produit
     * @param string $method
     * @return Payment
     */
    public static function generate($student, $product, $method = 'CHQ')
    {
        $payment = new Payment();
        $payment->setBillId(self::generateUUID());
        $payment->setDate(new \DateTime());
        $payment->setStudent($student);
        $payment->setProduct($product);
        $payment->setMethod($method);
        return $payment;
    }

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

    public function __toString(){
        return $this->getProduct() ." - ".$this->billId;
    }

    public static function generateUUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }

    public static function handleMultipleProducts(Payment $payment, Etudiant $student = null){
        /*###############################################################################
         * Information about this strange engine: (READ IT)
         * The form to input a new payment allows to select multiple Produits
         * but for PERFORMANCES reason in SQL requests the model of Payment only
         * allow to refer one Produit per Payment so to recognise products which
         * has been bought together we use a bill number which is an UUID so
         * it's unique.
         */
        $result = array();
        if($payment->getMethod() == 'NONE'){
            return $result;
        }
        if($payment->getProduct() instanceof ArrayCollection){
            $billId = Payment::generateUUID();
            /** @var Produit $product */
            foreach($payment->getProduct() as $product){
                $p = new Payment();
                $p->setMethod($payment->getMethod());
                $p->setProduct($product);
                $p->setDate(new \DateTime());
                $p->setBillId($billId);
                if($student)
                    $p->setStudent($student);
                $result[] = $p;
            }
        } else {
            if($student)
                $payment->setStudent($student);
            $payment->setBillId(Payment::generateUUID());
            $payment->setDate(new \DateTime());
            $result[] = $payment;
        }
        return $result;
    }
}

