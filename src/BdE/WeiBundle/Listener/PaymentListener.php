<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 24/08/15
 * Time: 22:35
 */

namespace BdE\WeiBundle\Listener;


use Cva\GestionMembreBundle\Entity\Payment;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Query;

/**
 * Class PaymentListener
 * This class listen the doctrine ORM module to act when a payment is acted. If the payment concerns a product which has
 * a waiting list, it will do the needed to update the waiting list.
 * @package BdE\WeiBundle\Listener
 */
class PaymentListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        if(!($args->getObject() instanceof Payment))
            return;
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $products = $entityManager->getRepository("CvaGestionMembreBundle:Produit")->findBy(['hasWaitingList'=>true]);
        if ($entity instanceof Payment) {
            if(in_array($entity->getProduct(),$products)){
                // Create a new ticket for this user and payment
                $ticket = $entityManager->getRepository("BdEWeiBundle:Waiting")
                    ->nextTicket($entity,$entity->getStudent());
                $entityManager->persist($ticket);
                $entityManager->flush();
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args){
        if(!($args->getObject() instanceof Payment))
            return;
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $products = $entityManager->getRepository("CvaGestionMembreBundle:Produit")->findBy(['hasWaitingList'=>true]);
        if ($entity instanceof Payment) {
            if(in_array($entity->getProduct(),$products)){
                // Retrieve the related ticket
                $ticket = $entityManager->getRepository("BdEWeiBundle:Waiting")->findOneBy(array(
                    'student' => $entity->getStudent(),
                    'payment' => $entity
                ));

                // Get the old rank
                $rank = $ticket->getRank();

                // Remove the user ticket
                $entityManager->remove($ticket);

                // Create an update query
                $update = $entityManager->getRepository("BdEWeiBundle:Waiting")->createQueryBuilder('waiting')->getQuery();
                $update->setDQL("UPDATE BdEWeiBundle:Waiting w SET w.rank = w.rank - 1 WHERE w.rank > ?1 AND w.payment IN ".
                 "(SELECT p.id FROM CvaGestionMembreBundle:Payment p WHERE p.product = ?2)");
                $update->setParameter(1, $rank);
                $update->setParameter(2, $entity->getProduct());

                // Execute all !
                $update->execute();
                $entityManager->flush();
            }
        }
    }
}