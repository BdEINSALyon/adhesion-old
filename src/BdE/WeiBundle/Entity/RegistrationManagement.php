<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 25/08/15
 * Time: 12:28
 */

namespace BdE\WeiBundle\Entity;


use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Exception\Exception;

class RegistrationManagement
{

    const UNREGISTERED = 0;
    const REGISTERED = 1;
    const PRE_REGISTERED = 2;
    const WAITING = 3;
    const PRE_WAITING = 4;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * RegistrationManagement constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getRegistrationStatus(Etudiant $student){
        $wei_status = array(
            'status' => self::UNREGISTERED,
            'waiting' => $student->getRank()
        );
        $products = $this->em->getRepository("CvaGestionMembreBundle:Produit");
        $studentProducts = $student->getProducts();
        if(in_array($products->getCurrentWEIRemboursement(),$studentProducts)){
            return $wei_status;
        }
        if(in_array($products->getCurrentWEI(), $studentProducts)){
            $wei_status['status'] = self::REGISTERED;
        } elseif(in_array($products->getCurrentWEIWaiting(), $studentProducts)){
            $wei_status['status'] = self::WAITING;
        } elseif(in_array($products->getCurrentWEIPreInscription(), $studentProducts)){
            $wei_status['status'] = self::PRE_REGISTERED;
        } elseif(in_array($products->getCurrentWEIPreWaiting(), $studentProducts)){
            $wei_status['status'] = self::PRE_WAITING;
        }
        return $wei_status;
    }

    public function getSeatsLeft(){
        return $this->getMaxStudent() - $this->countForWEIProduct($this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI());
    }

    public function getPreSeatsLeft(){
        return $this->getMaxStudent() - $this->countForWEIProduct($this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIPreInscription());
    }

    public function getMaxStudent(){
        return intval($this->em->getRepository("BdEMainBundle:Config")->get("wei.nbMaxBizuths","450"));
    }

    /**
     * Count number of student who has bought a product which has not been refunded.
     * @param Produit $product The product to count
     * @return mixed Number of student who has this product and are not refunded
     */
    public function countForWEIProduct(Produit $product)
    {
        $filterBy = $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIRemboursement();
        $query = $this->em->createQueryBuilder()->select("COUNT(student)")->from("CvaGestionMembreBundle:Etudiant", "student")
            ->join("student.payments", "payments")->where("payments.product = ?1")
            ->andWhere("NOT EXISTS (SELECT 1 FROM CvaGestionMembreBundle:Etudiant e LEFT JOIN e.payments pay WHERE pay.product = ?2 AND e = student)")
            ->setParameter(1, $product)->setParameter(2, $filterBy);
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Get all students who has bought a product and has not been refunded.
     * @param Produit $product The product to select
     * @return array The Students who has this product and has not been refunded
     */
    public function getStudentsForWEIProduct(Produit $product){
        $filterBy = $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIRemboursement();
        $query = $this->em->createQueryBuilder()->select("student")->from("CvaGestionMembreBundle:Etudiant","student")
            ->join("student.payments", "payments")->where("payments.product = ?1")
            // Remove students refunded
            ->andWhere("NOT EXISTS (SELECT 1 FROM CvaGestionMembreBundle:Etudiant e LEFT JOIN e.payments pay WHERE pay.product = ?2 AND e = student)")
            ->setParameter(1, $product)->setParameter(2, $filterBy);
        if($product->hasWaitingList())
            $query->join('student.waiting','waiting')->orderBy('waiting.rank');
        return $query->getQuery()->getResult();
    }

    /**
     * Remove a student from the waiting list.
     * The student will lost his rank and all student after him will up by one rank.
     * @param Etudiant $student The student to remove from the waiting ticketing
     * @param Produit $product The product which has been ticketed
     */
    public function removeFromWaitingList(Etudiant $student, Produit $product){
        // Retrieve the related ticket
        $tickets = $this->em->getRepository("BdEWeiBundle:Waiting")->findBy([
            'student'=>$student
        ]);
        foreach ($tickets as $k => $t ) {
            if($t->getPayment()->getProduct() != $product){
                unset($tickets[$k]);
            }
        }
        /** @var Waiting[] $tickets */
        if(!is_array($tickets)){
            $tickets = array($tickets);
        }
        foreach ($tickets as $ticket) {
            // Create an update query
            $update = $this->em->getRepository("BdEWeiBundle:Waiting")->createQueryBuilder('waiting')->getQuery();
            $update->setDQL("UPDATE BdEWeiBundle:Waiting w SET w.rank = w.rank - 1 WHERE w.rank > ?1");
            $update->setParameter(1, $ticket->getRank());

            // Execute all !
            $update->execute();

            // Remove the user ticket
            $this->em->remove($ticket);
        }
        $this->em->flush();
    }

    /**
     * Count number of student which are in front of a student in waiting list.
     * @param Etudiant $student The student (the function assumes that he has a waiting ticket)
     * @return int The number of student
     */
    private function countStudentsWithBetterRank(Etudiant $student){
        $query = $this->em->createQueryBuilder()->select("COUNT(e)")->from("CvaGestionMembreBundle:Etudiant","e")
            ->join("e.waiting","waiting")->where("waiting.rank < ?1")->getQuery();
        return $query->setParameter(1, $student->getRank())->getSingleScalarResult();
    }

    /**
     * @param $student Etudiant
     * @param string $paymentMethod
     * @return int
     */
    public function register(Etudiant $student, $paymentMethod = null)
    {
        $products = $this->em->getRepository("CvaGestionMembreBundle:Produit");
        $studentProducts = $student->getProducts();

        // If it's a pre-registered, put it in the WEI ;-)
        if (in_array($products->getCurrentWEIPreInscription(), $studentProducts)){
            if ($this->getSeatsLeft() <= 0){
                throw new Exception("No seats in WEI for PreRegistered students");
            };
            return $this->_registerToWei($student, $paymentMethod)?1:0;
        }

        // If it's a pre-registered in Waiting List
        if (in_array($products->getCurrentWEIPreWaiting(), $studentProducts)){
            $numberOfStudentHavingPriority =
                $this->countStudentsWithBetterRank($student) + // Student with a better rank on waiting list
                $this->countForWEIProduct($products->getCurrentWEIPreInscription()) + // Student pre-register has priority on waiting students
                $this->countForWEIProduct($products->getCurrentWEI()); // Students registered to WEI
            if ($numberOfStudentHavingPriority < $this->getMaxStudent()) {
                // There is enough seats in WEI to register this user
                return $this->_registerToWei($student, $paymentMethod)?1:0;
            } else {
                // Must move to the other waiting list
                foreach ($student->getPayments() as $payment) {
                    if ($payment->getProduct() == $products->getCurrentWEIPreWaiting()) {
                        $payment->setProduct($products->getCurrentWEIWaiting());
                        if(null != $paymentMethod){
                            $payment->setMethod($paymentMethod);
                        }
                        $this->em->persist($payment);
                        $this->em->flush();
                        return 2;
                    }
                }
            }
            return 0;
        }

        if(in_array($products->getCurrentWEI(), $studentProducts) || in_array($products->getCurrentWEIWaiting(), $studentProducts)){
            return 3; // Can not be registered because it's already
        }

        // If the student is not registred to a product, put him in a waiting list
        $payment = null;
        if($paymentMethod == null){ // Register in pre-registered Waiting List if he pays nothing - Case not usual
            $payment = Payment::generate($student, $products->getCurrentWEIPreWaiting());
        } else {
            $payment = Payment::generate($student, $products->getCurrentWEIWaiting(), $paymentMethod);
        }
        $this->em->persist($payment);
        $this->em->flush();
        return 2;
    }

    /**
     * Unregister a student from the WEI.
     * This function will look for all products related to the WEI and will refund it, if it's not.
     * @param Etudiant $student The student to refund
     */
    public function unregister(Etudiant $student){
        $products = $this->em->getRepository("CvaGestionMembreBundle:Produit");
        $weiWithoutRefundProducts = [
            $products->getCurrentWEIPreWaiting(),
            $products->getCurrentWEIPreInscription()
        ];
        $weiWithRefundProducts = [
            $products->getCurrentWEI(),
            $products->getCurrentWEIWaiting()
        ];
        if($student->hasProduct($products->getCurrentWEIRemboursement())){
            return;
        }
        foreach($student->getPayments() as $payment){
            if(in_array($payment->getProduct(), $weiWithoutRefundProducts)){
                $this->em->remove($payment);
                if($payment->getProduct()->hasWaitingList()){
                    $this->removeFromWaitingList($student, $payment->getProduct());
                }
            } elseif(in_array($payment->getProduct(), $weiWithRefundProducts)){
                if($payment->getProduct()->hasWaitingList()){
                    $this->removeFromWaitingList($student, $payment->getProduct());
                }
                $payment = Payment::generate($student, $products->getCurrentWEIRemboursement());
                $this->em->persist($payment);
            }
        }
        $this->em->flush();
    }

    private function _registerToWei(Etudiant $student, $paymentMethod = null){
        $products = $this->em->getRepository("CvaGestionMembreBundle:Produit");
        $allowedProducts = [
            $products->getCurrentWEIPreInscription(),
            $products->getCurrentWEIPreWaiting(),
            $products->getCurrentWEIWaiting()
        ];
        if(in_array($products->getCurrentWEI(), $student->getProducts())){
            return true;
        }
        /** @var Payment $payment */
        foreach ($student->getPayments() as $payment) {
            if (in_array($payment->getProduct(), $allowedProducts)) {
                $this->em->remove($payment);
                if($payment->getProduct()->hasWaitingList()){
                    $this->removeFromWaitingList($student, $payment->getProduct());
                }
                $newPayment = new Payment();
                $newPayment->setBillId($payment->getBillId());
                $newPayment->setMethod($paymentMethod == null?$payment->getMethod():$paymentMethod);
                $newPayment->setStudent($payment->getStudent());
                $newPayment->setDate($payment->getDate());
                $newPayment->setProduct($products->getCurrentWEI());
                $this->em->persist($newPayment);
                $this->em->flush();
                return true;
            }
        }
        return false;
    }
}