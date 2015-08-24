<?php

namespace BdE\WeiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegistrationController extends Controller
{
    /**
     * @Route(path="/{id}/sidebar", name="bde_wei_registration_sidebar", options={"expose"=true})
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function sidebarAction($id){
        return $this->render("@BdEWei/Registration/sidebar.html.twig",array(
            'etu' => $this->get("doctrine.orm.entity_manager")
                ->getRepository("CvaGestionMembreBundle:Etudiant")->find($id)
        ));
    }

    /**
     * @Route("/preregistered",name="bde_wei_registration_pre")
     * @Template()
     */
    public function preIndexAction()
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIPreInscription();
        $qb = $em->createQueryBuilder()->select("student")->from("CvaGestionMembreBundle:Etudiant","student")
            ->join("student.payments", "payments")->where("payments.product = ?1")->setParameter(1,$product);
        return array(
                'students' => $qb->getQuery()->getResult()
            );
    }

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
