<?php

namespace BdE\MainBundle\Controller;

use BdE\MainBundle\Entity\AzureRole;
use BdE\MainBundle\Form\AzureRoleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends Controller
{

    public function showAction($data){
        $mail = $this->get("bde.main.mailer_service")->generateMailFromBinData($data);
        return new Response($mail['body']);
    }

    public function demoAction(){
        $mail = $this->get("bde.main.mailer_service")->generateMailFromData(
            $this->get('doctrine.orm.entity_manager')->getRepository('BdEMainBundle:Mail')->find(2),
            $this->get('doctrine.orm.entity_manager')->getRepository('CvaGestionMembreBundle:Etudiant')->find(229)
            );
        return new Response($mail['body']);
    }
}