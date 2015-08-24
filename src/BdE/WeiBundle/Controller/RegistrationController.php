<?php

namespace BdE\WeiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegistrationController extends Controller
{
    /**
     * @Route("/preregistered",name="bde_wei_registration_pre")
     * @Template()
     */
    public function preIndexAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/registered",name="bde_wei_registration_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/preregistered-waiting",name="bde_wei_registration_pre_waiting")
     * @Template()
     */
    public function preWaitingIndexAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/registered-waiting",name="bde_wei_registration_index_waiting")
     * @Template()
     */
    public function indexWaitingAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/register",name="bde_wei_registration_new")
     * @Template()
     */
    public function registerAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/unregister/{id}",name="bde_wei_registration_delete")
     * @Template()
     */
    public function unregisterAction()
    {
        return array(
                // ...
            );    }

}
