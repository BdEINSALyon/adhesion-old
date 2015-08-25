<?php

namespace BdE\WeiBundle\Controller;

use BdE\WeiBundle\Form\AffectationType;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @Route(path="/{id}/sidebar", name="bde_wei_registration_sidebar", options={"expose"=true})
     * @param Request $request
     * @param mixed $id
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function sidebarAction(Request $request, $id){
        $em = $this->get("doctrine.orm.entity_manager");
        $student = $em
            ->getRepository("CvaGestionMembreBundle:Etudiant")->find($id);
        $studentProducts = $student->getProducts();
        $products = $em->getRepository("CvaGestionMembreBundle:Produit");

        $isWaiting = in_array($products->getCurrentWEIPreWaiting(),$studentProducts) ||
            in_array($products->getCurrentWEIWaiting(), $studentProducts);
        $isPreregistered = in_array($products->getCurrentWEIPreWaiting(),$studentProducts) ||
            in_array($products->getCurrentWEIPreInscription(), $studentProducts);

        $fb = $this->createFormBuilder()
            ->add('action','choice',array(
                'choices'=>[
                    "Valider inscription WEI",
                    "Valider inscription Liste attente WEI",
                ]
            ))->add('buttons','form_actions');

        $affectation = $this->handleAffectationForm($request, $student);
        if($affectation instanceof Response)
            return $affectation;

        return $this->render("@BdEWei/Registration/sidebar.html.twig",array(
            'etu' => $student,
            'form'=> $fb->getForm()->createView(),
            'affectation' => $affectation->createView(),
            'isWaiting' => $isWaiting,
            'isPreregistered' => $isPreregistered
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
            'students' => $this->get("bde.wei.registration_management")->getStudentsForWEIProduct($product)
        );
    }

    /**
     * @Route("/registered",name="bde_wei_registration_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI();
        $this->get("bde.wei.registration_management")->countForWEIProduct($product);

        return array(
            'students' => $this->get("bde.wei.registration_management")->getStudentsForWEIProduct($product),
            'seatsLeft' => $this->get("bde.wei.registration_management")->getSeatsLeft()
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
        $qb = $this->get("bde.wei.registration_management")->getStudentsForWEIProduct($product);

        return array(
            'students' => $this->get("bde.wei.registration_management")->getStudentsForWEIProduct($product)
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
        return array(
            'students' => $this->get("bde.wei.registration_management")->getStudentsForWEIProduct($product),
            'canRegister' => $this->get("bde.wei.registration_management")->getSeatsLeft()>0
        );
    }

    /**
     * @Route("/register/{id}",name="bde_wei_registration_new")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerAction(Request $request, $id)
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $student = $em->getRepository("CvaGestionMembreBundle:Etudiant")->find($id);
        $products = $em->getRepository("CvaGestionMembreBundle:Produit");
        $studentProducts = $student->getProducts();

        if(in_array($products->getCurrentWEIWaiting(), $studentProducts)){
            if($this->get("bde.wei.registration_management")->getSeatsLeft()>0){
                /** @var Payment $payment */
                foreach ($student->getPayments() as $payment) {
                    if($payment->getProduct() == $products->getCurrentWEIWaiting()){
                        $em->remove($payment);
                        $newPayment = new Payment();
                        $newPayment->setBillId($payment->getBillId());
                        $newPayment->setMethod($payment->getMethod());
                        $newPayment->setStudent($payment->getStudent());
                        $newPayment->setDate($payment->getDate());
                        $newPayment->setProduct($products->getCurrentWEI());
                        $em->persist($newPayment);
                    }
                }
                $em->flush();
                $this->addFlash('success',"Bizuth ajouté au WEI !");
            } else {
                $this->addFlash('error',"Pas de place pour lui !");
            }
        } else {
            $this->addFlash('error',"Pas dans la liste d'attente !");
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/unregister/{id}",name="bde_wei_registration_delete",options={"expose"=true})
     * @template
     */
    public function unregisterAction($id)
    {

        $em = $this->get("doctrine.orm.entity_manager");
        $student = $em->getRepository("CvaGestionMembreBundle:Etudiant")->find($id);
        $products = $em->getRepository("CvaGestionMembreBundle:Produit");
        $studentProducts = $student->getProducts();

        if(in_array($products->getCurrentWEI(),$studentProducts) or in_array($products->getCurrentWEIWaiting(), $studentProducts)){
            $payment = new Payment();
            $payment->setBillId(Payment::generateUUID());
            $payment->setProduct($products->getCurrentWEIRemboursement());
            $payment->setStudent($student);
            $payment->setDate(new \DateTime());
            $payment->setMethod("CHQ");
            $em->persist($payment);
        } else {
            /** @var Payment $payment */
            foreach ($student->getPayments() as $payment) {
                if($payment->getProduct() == $products->getCurrentWEIPreInscription() ||
                    $payment->getProduct() == $products->getCurrentWEIPreWaiting()){
                    $em->remove($payment);
                }
            }
        }
        $student->setBungalow(null);
        $student->setBus(null);
        $em->persist($student);

        foreach($studentProducts as $product)
            $this->get('bde.wei.registration_management')->removeFromWaitingList($student,$product);

        $em->flush();

        return array();
    }

    /**
     * @param Request $request
     * @param $student
     * @return \Symfony\Component\Form\Form|Response
     */
    public function handleAffectationForm(Request $request, Etudiant $student)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $bungalowNotFull = $em->getRepository("BdEWeiBundle:Bungalow")->getAllNotFullByGender($student->getCivilite());
        $busNotFull = $em->getRepository("BdEWeiBundle:Bus")->getAllNotFull();
        if($student->getBungalow() != null && !in_array($student->getBungalow(),$bungalowNotFull)){
            $bungalowNotFull[] = $student->getBungalow();
        }
        if($student->getBus() != null && !in_array($student->getBus(),$busNotFull)){
            $busNotFull[] = $student->getBus();
        }
        $options = array(
            'bungalow' => $bungalowNotFull,
            'bus' => $busNotFull,
            'action' => $this->generateUrl("bde_wei_registration_sidebar",array('id'=>$student->getId()))
        );
        $affectation = $this->createForm(new AffectationType(), $student, $options);

        $affectation->handleRequest($request);

        if($affectation->isValid()){
            $data = $affectation->getData();
            $em->persist($data);
            $em->flush();
            $this->addFlash("success","Etudiant affecté");
            return $this->redirectToRoute("bde_wei_registration_index");
        }

        return $affectation;
    }

}
