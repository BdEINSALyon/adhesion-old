<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 30/08/15
 * Time: 12:57
 */

namespace BdE\MainBundle\Listener;


use Cva\GestionMembreBundle\Entity\Payment;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Mail sender.
 * This class listen doctrine persists to send mails to students on payments.
 * @package BdE\MainBundle\Listener
 */
class MailProductSender
{

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
        /** @var Payment $entity */
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $mail = $entityManager->getRepository("BdEMainBundle:Mail")->getMail($entity->getStudent(), $entity->getProduct());
        if($mail){
            $mailgun = $this->containerInterface->get("bde.mailgun");
            $mailer = $this->containerInterface->get("bde.main.mailer_service");
            $mail_data = $mailer->generateMailFromData($mail, $entity->getStudent());
            $mb = $mailgun->MessageBuilder();
            $mb->setSubject($mail_data['subject']);
            $mb->setHtmlBody($mail_data['body']);
            $mb->setFromAddress($entityManager->getRepository("BdEMainBundle:Config")->get("bde.mail.sender", "OrgaIf BdE <bde.if@insa-lyon.fr>"));
            $mb->addToRecipient($entity->getStudent()->getMail());

            $mailgun->sendMessage($entityManager->getRepository("BdEMainBundle:Config")->get("mailgun.domain", "mail.vienne.me"), $mb->getMessage());
        }
    }

}