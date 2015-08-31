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
            $mb = $mailgun->MessageBuilder();
            $twig = new \Twig_Environment( new \Twig_Loader_Array(
                ['mail.'.$mail->getId() => $mail->getContent()]
            ),
                array(
                    'autoescape' => false
                )
            );
            $mb->setSubject($mail->getSubject());
            $mb->setHtmlBody($this->containerInterface->get("twig")->render("@BdEMain/Mail/common.html.twig",array(
                'content' => $twig->render("mail.".$mail->getId(),array(
                    'student'=>$entity->getStudent()
                )),
                'config' => array(
                    'title' => $mail->getSubject(),
                    'company' => "BdE INSA Lyon",
                    'student'=>$entity->getStudent()
                ),
                'why_this_mail' => "Vous recevez ce mail car vous êtes/avez été membre du BdE INSA Lyon"
            )));
            $mb->setFromAddress($entityManager->getRepository("BdEMainBundle:Config")->get("bde.mail.sender", "OrgaIf BdE <bde.if@insa-lyon.fr>"));
            $mb->addToRecipient($entity->getStudent()->getMail());

            $mailgun->sendMessage($entityManager->getRepository("BdEMainBundle:Config")->get("mailgun.domain", "mail.vienne.me"), $mb->getMessage());
        }
    }

}