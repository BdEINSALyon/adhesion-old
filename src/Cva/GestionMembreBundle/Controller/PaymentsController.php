<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 18/08/15
 * Time: 21:52
 */

namespace Cva\GestionMembreBundle\Controller;

use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Cva\GestionMembreBundle\Form\StudentPaymentType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends Controller
{

    /**
     * @Route(path="/import", name="cva_membership_payments_import")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function importAction(Request $request){
        if($request->isMethod('POST')){
            $out="";
            $var = $request->request->get('students');
            $em = $this->get('doctrine.orm.entity_manager');
            $em->beginTransaction();
            $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVA()[0];
            $out.= '<b>Importation de '. count($var).' étudiant(s) :</b><br>';
            if($var!=null) {
                foreach ($var as $student) {
                    if ($student['student'] == '') {
                        $out .= '<span class="text-error">'.$student['firstname'].' '.$student['lastname'].' ('
                            .$student['mail'].') est déjà adhérant</span><br>';
                        continue;
                    }
                    $new = false;
                    $r = $em->getRepository("CvaGestionMembreBundle:Etudiant")->findOneBy(array('numEtudiant' => $student['student']));
                    if ($r == null) {
                        $r = new Etudiant();
                        $r->setFirstName($student['firstname']);
                        $r->setName($student['lastname']);
                        $r->setCivilite($student['sex']);
                        $r->setMail($student['mail']);
                        $r->setNumEtudiant($student['student']);
                        if ($student['birthday'] != null) {
                            $birthday = new \DateTime();
                            $birthday->setTimestamp(strtotime($student['birthday']));
                            $r->setBirthday($birthday);
                        }
                        $new = true;
                    } else {
                        $c = $em->getRepository("CvaGestionMembreBundle:Payment")->createQueryBuilder('p')
                            ->select('COUNT(p.id)')
                            ->where('p.student = ?1')->andWhere('p.product IN (?2)')
                            ->setParameter(1, $r)->setParameter(2, $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVAIds())
                            ->getQuery()->getSingleScalarResult();
                        if ($c > 0) {
                            $out .= '<span class="text-warning">'.$r.' ('
                                .$r->getNumEtudiant().') est déjà adhérant</span><br>';
                            continue;
                        }
                    }
                    $r->setAnnee($student['year']);
                    $r->setDepartement($student['depart']);
                    $em->persist($r);
                    $payment = Payment::generate($r, $product, $student['payment']);
                    $em->persist($payment);
                    $out .= '<span class="text-'.($new?'success':'info').'">'
                        .$r.' ('
                        .$r->getNumEtudiant().')' .
                        ($new ? ' a été créé et' : '') . ' a acheté le produit ' . $product->getName() . '</span><br>';

                }
            }
            $em->flush();
            $em->commit();

            return $this->render("CvaGestionMembreBundle:Payments:importResult.html.twig",array(
                'out'=>$out
            ));
        } else {
            return $this->render("CvaGestionMembreBundle:Payments:import.html.twig");
        }
    }

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

        $httpCode = 200;

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
                $httpCode = 200;
            } else {
                $httpCode = 400;
            }
        }

        $response = $this->render("CvaGestionMembreBundle:Payments:editModal.html.twig", array(
            'form' => $form->createView(),
            'id' => $id
        ));
        $response->setStatusCode($httpCode);
        return $response;
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