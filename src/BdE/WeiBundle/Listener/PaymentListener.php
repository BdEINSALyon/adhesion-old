<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 24/08/15
 * Time: 22:35
 */

namespace BdE\WeiBundle\Listener;


use BdE\WeiBundle\Entity\RegistrationManagement;
use Cva\GestionMembreBundle\Entity\Payment;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PaymentListener
 * This class listen the doctrine ORM module to act when a payment is acted. If the payment concerns a product which has
 * a waiting list, it will do the needed to update the waiting list.
 * @package BdE\WeiBundle\Listener
 */
class PaymentListener
{

    private $registration;
    private $containerInterface;

    /**
     * PaymentListener constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

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
                $this->containerInterface->get("bde.wei.registration_management")
                    ->removeFromWaitingList($entity->getStudent(), $entity->getProduct());
            }
        }
    }
}