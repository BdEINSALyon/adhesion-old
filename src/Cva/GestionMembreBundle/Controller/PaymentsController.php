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

        // Select only product which has not be bought by this student
        $boughtProducts = array();
        /** @var Payment[] $payments */
        $payments = $student->getPayments();
        foreach($payments as $payment){
            $boughtProducts[]=$payment->getProduct()->getId();
        }

        // The query to achieve what we are looking for
        $qb = $em->createQueryBuilder()->select("p")->from("CvaGestionMembreBundle:Produit","p")
            ->where("p.active = true");
        if(count($boughtProducts)>0){ // This request bug if $boughtProducts is empty
            $qb->andWhere("p.id NOT IN (?2)")->setParameter(2,$boughtProducts);
        }
        $q = $qb->getQuery();

        // Create the form used for this payment
        $form = $this->createForm(new PaymentType(),null,array(
            "products" => $q->getResult()
        ));

        if($request->isMethod("POST")){
            // Handle form
            $form->handleRequest($request);
            if($form->isValid()){
                /** @var Payment $payment */
                $payment = $form->getData();
                /*###############################################################################
                 * Information about this strange engine: (READ IT)
                 * The form to input a new payment allows to select multiple Produits
                 * but for PERFORMANCES reason in SQL requests the model of Payment only
                 * allow to refer one Produit per Payment so to recognise products which
                 * has been bought together we use a bill number which is an UUID so
                 * it's unique.
                 */
                if($payment->getProduct() instanceof ArrayCollection){
                    $billId = Payment::generateUUID();
                    /** @var Produit $product */
                    foreach($payment->getProduct() as $product){
                        $p = new Payment();
                        $p->setMethod($payment->getMethod());
                        $p->setProduct($product);
                        $p->setDate(new \DateTime());
                        $p->setBillId($billId);
                        $p->setStudent($student);
                        $em->persist($p);
                    }
                } else {
                    $payment->setStudent($student);
                    $payment->setBillId(Payment::generateUUID());
                    $payment->setDate(new \DateTime());
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