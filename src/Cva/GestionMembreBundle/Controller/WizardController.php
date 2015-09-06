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
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Form\PaymentType;
use Cva\GestionMembreBundle\Form\StudentPaymentType;
use Cva\GestionMembreBundle\Form\StudentType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WizardController extends Controller
{

    /**
     * @Route(path="/search", name="wizard_search")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function searchAction(Request $request){

        $searchFormBuilder = $this->createFormBuilder([],['csrf_protection' => false]);
        $searchFormBuilder->add('search','text', [
            'label' => false,
            'attr' => [
                'placeholder'=>'Entrer le nom ou prénom d\'un étudiant',
                'autocomplete'=> 'off'
            ]
        ]);

        $searchForm = $searchFormBuilder->getForm();

        $searchForm->handleRequest($request);

        if($searchForm->isValid()){
            $search = $searchForm->getData()['search'];
            $result = $this->get('doctrine.orm.entity_manager')
                ->getRepository("CvaGestionMembreBundle:Etudiant")
                ->search($search);
            if($request->isXmlHttpRequest()){
                return $this->render("@CvaGestionMembre/Wizard/searchResult.html.twig",[
                    'result' => $result,
                    'va' => $this->get('bde.va_check')
                ]);
            }
        }

        return $this->render("CvaGestionMembreBundle:Wizard:search.html.twig",array(
            'search' => $searchForm->createView(),
            'result' => isset($result)?$result:false,
            'va' => $this->get('bde.va_check')
        ));

    }

    /**
     * @Route(path="/student/{id}", name="wizard_student")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function studentAction($id, Request $request){

        $em = $this->get('doctrine.orm.entity_manager');
        $students = $em
            ->getRepository("CvaGestionMembreBundle:Etudiant");
        if($id == "new"){
            $student = new Etudiant();
            $student->setDepartement("PC");
        } else {
            $student = $students->find($id);
            if(!$student)
                throw $this->createNotFoundException('Not found student '.$id);
        }

        $preRegisteredForWEI = $this->_is_preregistered_for_wei($student) ||
            $student->hasProduct($em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI())
            || $student->hasProduct($em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIWaiting());

        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('student',new StudentType(),array(
            'label'=>false,
            'data' => $student
        ));
        if(!$this->get("bde.va_check")->checkVA($student)) {
            $formBuilder->add('wei', 'choice', [
                "label" => "WEI",
                "choices" => [
                    "WEI" => $preRegisteredForWEI ? "Confirme qu'il vient au WEI" : "Veut s'inscrire au WEI",
                    "NOWEI" => $preRegisteredForWEI ? "Ne veut plus aller au WEI" : "Ne veut pas s'inscrire au WEI"
                ],
                "expanded" => true,
                'required' => true,
                "multiple" => false,
                'data' => $preRegisteredForWEI ? "WEI" : "NOWEI",
                'disabled' => $student->hasProduct($em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI())
                    || $student->hasProduct($em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEIWaiting())
            ]);
            $formBuilder->add('va', 'choice', [
                "label" => "Adhesion VA",
                "choices" => [
                    "VA" => "Veut adhérer à la VA",
                    "NOVA" => "Ne veut pas adhérer à la VA"
                ],
                "expanded" => true,
                'required' => true,
                "multiple" => false,
                "disabled" => $this->get("bde.va_check")->checkVA($student),
                'data' => "VA"
            ]);
            $formBuilder->add('methodPayment', 'choice', array(
                    'choices' => array(
                        'CHQ' => 'Cheque',
                        'CB' => 'Carte Bancaire',
                        'ESP' => 'Espèces'
                    ),
                    'mapped' => true,
                    'required' => true,
                    'expanded' => true,
                    "disabled" => $this->get("bde.va_check")->checkVA($student),
                    'label' => "Moyen de paiement",
                    'data' => 'CHQ'
                )
            );
        }
        $formBuilder->add('target','hidden');
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if($form->isValid()){
            $data = $form->getData();
            /** @var Etudiant $student */
            $student = $data['student'];
            $em->persist($student);
            $em->flush();
            $wantWei = isset($data['wei']) ? $data['wei'] == 'WEI' : false;
            $wantVA = isset($data['va']) ? $data['va'] == 'VA' : false;
            $methodPayement = $data['methodPayment'];

            if(!$wantVA && !$this->get("bde.va_check")->checkVA($student)){
                $this->addFlash("warning","L'Etudiant a refusé l'adhésion VA !");
            } else if($wantVA) {
                $va = null;
                if(!$this->get("bde.va_check")->checkVA($student)) { // if the current user is not VA
                    if ($student->getAnnee() == '1') {
                        $va = $em->getRepository("CvaGestionMembreBundle:Produit")->getVAProduct('B');
                    } else {
                        $va = $em->getRepository("CvaGestionMembreBundle:Produit")->getVAProduct('A');
                    }
                    $paymentVA = Payment::generate($student, $va, $methodPayement);
                    $em->persist($paymentVA);
                }
                if($wantWei && $student->getAnnee() == '1'){
                    $this->get("bde.wei.registration_management")->register($student, $methodPayement);
                } elseif($student->getAnnee() == '1'){
                    $this->get("bde.wei.registration_management")->unregister($student);
                }
                $em->flush();
            }

            return $this->redirectToRoute("wizard_student_abstract",array('id'=>$student->getId()));
        }

        $products = $em->getRepository("CvaGestionMembreBundle:Produit")->createQueryBuilder('p')->where('p.active = true')->getQuery()->getArrayResult();
        $productsIndexed = [];
        foreach ($products as $product) {
            if(isset($product['name']))
            $productsIndexed[$product['name']] = $product;
        }


        return $this->render("CvaGestionMembreBundle:Wizard:edit.html.twig",array(
            'form' => $form->createView(),
            'products' => $productsIndexed,
            'va' => $this->get('bde.va_check'),
            'student' => $student
        ));

    }


    /**
     * @Route(path="/abstract/{id}", name="wizard_student_abstract")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function abstractAction($id, Request $request){

        $student = $this->get("doctrine.orm.entity_manager")->getRepository("CvaGestionMembreBundle:Etudiant")->find($id);

        if(!$student){
            throw $this->createNotFoundException("User ".htmlentities($id)." not found!");
        }

        return $this->render("@CvaGestionMembre/Wizard/resume.html.twig",array(
            'student' => $student,
            'va' => $this->get("bde.va_check")->checkVA($student),
            'wei' => $this->get("bde.wei.registration_management")
        ));
    }

    /**
     * Determin if the student is already registred to go to the wei
     * @param Etudiant $student
     * @return bool True if he's registered
     */
    private function _is_preregistered_for_wei(Etudiant $student)
    {
        $produitRepository = $this->get("doctrine.orm.entity_manager")->getRepository("CvaGestionMembreBundle:Produit");
        $validProducts = [
            $produitRepository->getCurrentWEIPreInscription(),
            $produitRepository->getCurrentWEIPreWaiting(),
        ];
        $intersect = array_intersect($validProducts, $student->getProducts());
        return count($intersect)>0;
    }

}