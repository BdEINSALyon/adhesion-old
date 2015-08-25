<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 18/08/15
 * Time: 21:52
 */

namespace Cva\GestionMembreBundle\Controller;

use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Form\PaymentType;
use Cva\GestionMembreBundle\Form\StudentPaymentType;
use Cva\GestionMembreBundle\Form\StudentType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends Controller
{

    /**
     * @Route(path="/", name="cva_membership_payments")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction(Request $request){

        throw $this->createNotFoundException();

    }

    /**
     * @Route(path="/s/{id}/new", name="cva_membership_payment_new_modal", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function registerModalAction(Request $request, $id){

        $em = $this->get("doctrine.orm.entity_manager");
        $student = $em->find("CvaGestionMembreBundle:Etudiant", $id);

        // Create the form used for this payment
        $form = $this->createForm(new StudentPaymentType(),null,array(
            "products" => $this->get("cva.gestion_membre.products")->getProductsFor($student),
            "none_enabled" => false
        ));

        if($request->isMethod("POST")){
            // Handle form
            $form->handleRequest($request);
            if($form->isValid()){
                /** @var Payment[] $payments */
                $payments = $form->getData();
                foreach ($payments as $payment) {
                    $payment->setStudent($student);
                    $em->persist($payment);
                }
                $em->flush();
                return new Response();
            }
        }

        return $this->render("CvaGestionMembreBundle:Payments:editModal.html.twig",array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    /**
     * @Route(path="/p/{id}/delete", name="cva_membership_payment_delete", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id){
        $em = $this->get("doctrine.orm.entity_manager");
        $em->remove($em->find("CvaGestionMembreBundle:Payment",$id));
        try{
            $em->flush();
        } catch(ForeignKeyConstraintViolationException $exception){
            return $this->render("::error.html.twig",array(
                "error_message"=>"Le Paiement ".$id." a encore des données qui lui sont liés, tu ne peux pas le supprimer !"
            ));
        }
        $this->addFlash("notice","Paiement ".$id." supprimé avec succès. Attention, prévient le trésorier si tu as déjà mis des sous dans la caisse !");
        return $this->redirect($request->headers->get('referer'));
    }

}