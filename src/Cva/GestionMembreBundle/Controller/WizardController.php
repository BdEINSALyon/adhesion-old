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
                    'result' => $result
                ]);
            }
        }

        return $this->render("CvaGestionMembreBundle:Wizard:search.html.twig",array(
            'search' => $searchForm->createView(),
            'result' => isset($result)?$result:false
        ));

    }

    /**
     * @Route(path="/student/{id}", name="wizard_student")
     * @param Request $request
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function studentAction($id, Request $request){

    }

}