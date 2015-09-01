<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 25/08/15
 * Time: 12:28
 */

namespace BdE\WeiBundle\Entity;


use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\ORM\EntityManager;

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
            $update->setParameter(2, $ticket->getPayment()->getProduct());

            // Execute all !
            $update->execute();

            // Remove the user ticket
            $this->em->remove($ticket);
        }
        $this->em->flush();
    }
}