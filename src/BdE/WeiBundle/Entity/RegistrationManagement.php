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

    public function getSeatsLeft(){
        return $this->getMaxStudent() - $this->countForWEIProduct($this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI());
    }

    public function getPreSeatsLeft(){
        return $this->getMaxStudent() - $this->countForWEIProduct($this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIPreInscription());
    }

    public function getMaxStudent(){
        return intval($this->em->getRepository("BdEMainBundle:Config")->get("wei.nbMaxBizuths","450"));
    }

    public function countForWEIProduct(Produit $product)
    {
        $filterBy = $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIRemboursement();
        $query = $this->em->createQueryBuilder()->select("COUNT(student)")->from("CvaGestionMembreBundle:Etudiant", "student")
            ->join("student.payments", "payments")->where("payments.product = ?1")
            ->andWhere("NOT EXISTS (SELECT 1 FROM CvaGestionMembreBundle:Etudiant e LEFT JOIN e.payments pay WHERE pay.product = ?2 AND e = student)")
            ->setParameter(1, $product)->setParameter(2, $filterBy);
        return $query->getQuery()->getSingleScalarResult();
    }


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
            if ($this->getSeatsLeft() > 0){
                throw new Exception("No seats in WEI for PreRegistered students");
            };
            return $this->_registerToWei($student, $paymentMethod)?1:0;
        }

        // If it's a pre-registered in Waiting List
        if (in_array($products->getCurrentWEIPreWaiting(), $studentProducts)) {
            if ($this->countForWEIProduct($products->getCurrentWEIPreInscription()) + $this->countForWEIProduct($products->getCurrentWEI()) < $this->getMaxStudent()) {
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

        // Now we are sure that's someone who has not registered
        $studentCount = $this->countForWEIProduct($products->getCurrentWEI()) +
            $this->countForWEIProduct($products->getCurrentWEIWaiting()) +
            $this->countForWEIProduct($products->getCurrentWEIPreWaiting()) +
            $this->countForWEIProduct($products->getCurrentWEIPreInscription());

        // If we have enought place for every one
        if($studentCount < $this->getMaxStudent()){
            return $this->_registerToWei($student)?1:0;
        } else {
        // Else Go to the waiting list
            $payment = null;
            if($paymentMethod == null){ // Register in pre-registered Waiting List
                $payment = Payment::generate($student, $products->getCurrentWEIPreWaiting());
            } else {
                $payment = Payment::generate($student, $products->getCurrentWEIWaiting(), $paymentMethod);
            }
            $this->em->persist($payment);
            $this->em->flush();
            return 2;
        }
    }

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
    }

    private function _registerToWei(Etudiant $student){
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
                $newPayment->setMethod($payment->getMethod());
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