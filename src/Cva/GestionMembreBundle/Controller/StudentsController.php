<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 18/08/15
 * Time: 21:52
 */

namespace Cva\GestionMembreBundle\Controller;

use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Form\StudentType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsController extends Controller
{

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
     * @Route(path="/", name="cva_membership_students")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction(Request $request){

        $q = $this->get("doctrine.orm.entity_manager")
            ->getRepository("CvaGestionMembreBundle:Etudiant")->getMembersQuery();

        return $this->render("CvaGestionMembreBundle:Students:index.html.twig",array(
            'adherent' => $q->getResult()
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

        if($request->isMethod("POST")){
            // Handle form
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($form->getData());
                $em->flush();
                return new Response();
            }
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
            } catch (ForeignKeyConstraintViolationException $exception) {
                return $this->render("::error.html.twig", array(
                    "error_message" => "L'étudiant " . $id . " a encore des données qui lui sont liés, tu ne peux pas le supprimer !"
                ));
            }
            $this->addFlash("notice", "Etudiant " . $id . " supprimé avec succès.");
        } else {
            $this->addFlash("error", "Etudiant ".$id." est introuvable !");
        }
        return $this->redirect($request->headers->get('referer'));
    }

}