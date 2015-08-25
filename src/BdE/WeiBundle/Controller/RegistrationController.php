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
        $student = $this->get("doctrine.orm.entity_manager")
            ->getRepository("CvaGestionMembreBundle:Etudiant")->find($id);

        $fb = $this->createFormBuilder()
            ->add('action','choice',array(
                'choices'=>[
                    "Valider inscription WEI",
                    "Valider inscription Liste attente WEI",
                ]
            ))->add('buttons','form_actions');

        return $this->render("@BdEWei/Registration/sidebar.html.twig",array(
            'etu' => $student,
            'form'=> $fb->getForm()->createView()
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
        $em = $this->get("doctrine.orm.entity_manager");
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI();
        $qb = $em->createQueryBuilder()->select("student")->from("CvaGestionMembreBundle:Etudiant","student")
            ->join("student.payments", "payments")->where("payments.product = ?1")->setParameter(1,$product);
        return array(
            'students' => $qb->getQuery()->getResult()
        );
    }

    /**
     * @Route("/preregistered-waiting",name="bde_wei_registration_pre_waiting")
     * @Template()
     */
    public function preWaitingIndexAction()
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIPreWaiting();
        $qb = $em->createQueryBuilder()->select("student")->from("CvaGestionMembreBundle:Etudiant","student")
            ->join("student.payments", "payments")->where("payments.product = ?1")->setParameter(1,$product)
            ->join('student.waiting','waiting')->join('waiting.payment','payment')->andWhere("payment.product = ?1")->orderBy('waiting.rank');
        $result = $qb->getQuery()->getResult();

        return array(
            'students' => $qb->getQuery()->getResult()
        );
    }

    /**
     * @Route("/registered-waiting",name="bde_wei_registration_index_waiting")
     * @Template()
     */
    public function indexWaitingAction()
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIWaiting();
        $qb = $em->createQueryBuilder()->select("student")->from("CvaGestionMembreBundle:Etudiant","student")
            ->join("student.payments", "payments")->where("payments.product = ?1")->setParameter(1,$product)
            ->join('student.waiting','waiting')->orderBy('waiting.rank');
        return array(
            'students' => $qb->getQuery()->getResult()
        );
    }

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
