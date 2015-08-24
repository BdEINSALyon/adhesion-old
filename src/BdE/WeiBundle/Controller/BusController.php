<?php

namespace BdE\WeiBundle\Controller;

use BdE\WeiBundle\Entity\Bus;
use BdE\WeiBundle\Form\BusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BusController extends Controller
{

    /**
     * @Route("/",name="bde_wei_bus")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
        // Load data
        $em = $this->getDoctrine()->getManager();
        $buses = $em->getRepository("BdEWeiBundle:Bus")->findAll();
        return $this->render("@BdEWei/Bus/index.html.twig",array('buses'=>$buses));
    }

    /**
     * @Route("/add",name="bde_wei_bus_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){
        // Load data
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new BusType(), new Bus());

        // Handle the form
        $form->handleRequest($request);

        // If valid, we act
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($form->getData());
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Bus ajouté');
            return $this->redirect($this->generateUrl('bde_wei_bus'));
        } else { // Else, recreate the page
            return $this->render('BdEWeiBundle:Bus:add.html.twig', array('form' => $form->createView(),));
        }
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"},name="bde_wei_bus_edit")
     * @Method({"GET","POST"})
     * @param Request $request
     * @param $id mixed Params for request which describe id of bus
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $bus = $em->getRepository("BdEWeiBundle:Bus")->find($id);

        if(!$bus){
            throw $this->createNotFoundException("Bus with id [".htmlentities($id)."] is not found");
        }

        $form = $this->createForm(new BusType(), $bus);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em->persist($form->getData());
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Bus modifié');
            return $this->redirect($this->generateUrl('bde_wei_bus'));
        }

        return $this->render('@BdEWei/Bus/edit.html.twig', array('form' => $form->createView(), 'idBus' => $id));
    }

    /**
     * @Route("/{id}/delete", requirements={"id" = "\d+"},name="bde_wei_bus_delete")
     * @Method({"GET","DELETE"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $busRepo = $em->getRepository("BdEWeiBundle:Bus");
        $bus = $busRepo->find($id);

        if(!$bus->canBeDeletedSafely()) {
            $this->get('session')->getFlashBag()->add('warning', 'Ce bus n\'est pas vide !');
            return $this->redirect($this->generateUrl('bde_wei_bus'));
        } else {
            $em->remove($bus);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Bus supprimé');
            return $this->redirect($this->generateUrl('bde_wei_bus'));
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/addMany",name="bde_wei_bus_add_many")
     * @Method({"GET"})
     */
    public function createMultipleAction(){
        // Get data from Form
        // The way to use a get from the request is bad but on one side you can't use symfony form on GET request
        // And on the other way you can't put it as url param because it comes from a form and JS is bad !
        $amount = $this->getRequest()->get("nbBus");

        $em = $this->getDoctrine()->getManager();
        $nbBus = intval($amount);

        if($nbBus <= 0){
            throw new \InvalidArgumentException("The amount of bus should not be null or negative");
        }

        for ($i = 0; $i < $nbBus; $i++) {
            $bus = new Bus();
            $bus->setNom("Bus ".$i);
            $bus->setNbPlaces(1000);
            $em->persist($bus);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
    }

}
