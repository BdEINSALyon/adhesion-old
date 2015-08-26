<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 18/08/15
 * Time: 21:52
 */

namespace Cva\GestionMembreBundle\Controller;

use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Form\PaymentType;
use Cva\GestionMembreBundle\Form\StudentPaymentType;
use Cva\GestionMembreBundle\Form\StudentType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsController extends Controller
{

    /**
     * @Route(path="/", name="cva_membership_students")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction(Request $request){

        $q = $this->get("doctrine.orm.entity_manager")
            ->getRepository("CvaGestionMembreBundle:Etudiant")->findAll();

        return $this->render("CvaGestionMembreBundle:Students:indexAll.html.twig",array(
            'adherent' => $q
        ));

    }

    /**
     * @Route(path="/old", name="cva_membership_students_old")
     * @param Request $request
     * @return Response
     */
    public function indexOldAction(Request $request){

        $q = $this->get("doctrine.orm.entity_manager")
            ->getRepository("CvaGestionMembreBundle:Etudiant")->getOldMembersQuery();

        return $this->render("CvaGestionMembreBundle:Students:index_old.html.twig",array(
            'adherent' => $q->getResult()
        ));

    }

    /**
     * @Route(path="/current", name="cva_membership_students_current")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexCurrentAction(Request $request){

        $q = $this->get("doctrine.orm.entity_manager")
            ->getRepository("CvaGestionMembreBundle:Etudiant")->getMembersQuery();

        return $this->render("CvaGestionMembreBundle:Students:index.html.twig",array(
            'adherent' => $q->getResult()
        ));

    }

    /**
     * @Route(path="/new", name="cva_membership_student_new", options={"expose"=true})
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function newAction(Request $request){
        $em = $this->get("doctrine.orm.entity_manager");

        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('student',new StudentType(),array(
            'label'=>false
        ));
        $formBuilder->add('payments',new StudentPaymentType(),array(
            "products" => $this->get("cva.gestion_membre.products")->getProducts(),
            "label" => false
        ));
        $formBuilder->add('target','hidden');
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if($form->isValid()){
            $data = $form->getData();
            $student = $data['student'];
            $em->persist($student);
            $em->flush($student);
            $em->beginTransaction();
            $memberMessage = "n'est pas encore membre !";
            $isMember = false;
            $vaIds = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVAIds();
            /** @var Payment $payment */
            foreach ($data['payments'] as $payment) {
                $payment->setStudent($student);
                if(in_array($payment->getProduct()->getId(),$vaIds)){
                    $memberMessage = "est membre du BdE !";
                    $isMember = true;
                }
                $em->persist($payment);
            }
            $em->flush();
            $em->commit();
            $this->addFlash('success',"L'adhérent ".$student." a été créé et ".$memberMessage);
            if($data['target'] == 'new'){
                return $this->redirectToRoute("cva_membership_student_new");
            }
            if($isMember){
                return $this->redirectToRoute("cva_membership_students_current");
            } else {
                return $this->redirectToRoute("cva_membership_students_old");
            }
        }

        return $this->render("CvaGestionMembreBundle:Students:new.html.twig",array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/{id}/sidebar", name="cva_membership_student_sidebar", options={"expose"=true})
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function sidebarAction($id){

        return $this->render("CvaGestionMembreBundle:Students:sidebar.html.twig",array(
            'etu' => $this->get("doctrine.orm.entity_manager")
                ->getRepository("CvaGestionMembreBundle:Etudiant")->find($id),
            "remplacantsWEI"=>array(),
            "remplacer"=>""
        ));
    }

    /**
     * @Route(path="/{id}/editModal", name="cva_membership_student_edit_modal", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editModalAction(Request $request, $id){


        $em = $this->get("doctrine.orm.entity_manager");
        $form = $this->createForm(new StudentType(), $em
            ->getRepository("CvaGestionMembreBundle:Etudiant")->find($id));

        $form->handleRequest($request);
        if($form->isValid()){
            $em->persist($form->getData());
            $em->flush();
            return new Response();
        } elseif($request->isMethod("POST")) {
            $json = array();
            $errors = $form->getErrors(true, true);
            foreach($errors as $error){
                $json[$error->getOrigin()->getName()] = $error->getMessage();
            }
            return new Response(json_encode($json), 400, ["Content-Type"=>"application/json"]);
        }

        return $this->render("@CvaGestionMembre/Students/edit.html.twig",array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    /**
     * @Route(path="/{id}/delete", name="cva_membership_student_delete", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id){
        $em = $this->get("doctrine.orm.entity_manager");
        $entity = $em->find("CvaGestionMembreBundle:Etudiant", $id);
        if($entity) {
            $em->remove($entity);
            try {
                $em->flush();
                $this->addFlash("notice", "Etudiant " . $entity->getFullName() . " supprimé avec succès.");
            } catch (ForeignKeyConstraintViolationException $exception) {
                $this->addFlash("error", "Etudiant " . $entity->getFullName() . " a encore des produits liés, impossible de supprimer.");
            }
        } else {
            $this->addFlash("error", "Etudiant ".$id." est introuvable !");
        }
        return $this->redirect($request->headers->get('referer'));
    }

}