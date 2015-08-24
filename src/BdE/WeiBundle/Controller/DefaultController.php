<?php

namespace BdE\WeiBundle\Controller;

use Cva\GestionMembreBundle\Entity\Produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $produits = $em->getRepository("CvaGestionMembreBundle:Produit");
        $data = $em->getRepository("BdEMainBundle:Config")->getConfig();
        $d = array();
        foreach ($data as $k => $v) {
            if(preg_match("/^wei\\./",$k)) {
                if (preg_match("/produit/", $k)) {
                    $v = $produits->find($v);
                }
                if($k == "wei.dateWEI"){
                    $v = new \DateTime($v);
                }
                $d[str_replace(".", "_", $k)] = $v;
            }
        }

        $builder = $this->createFormBuilder();
        $config = $builder
            ->add("wei_nbMaxBizuths","integer",[
                'label' => "Nombre de participants"
            ])
            ->add("wei_bungMixtes","choice",[
                'label' => "Types de bungalow",
                'choices' => ["1"=>"Homme, Femme et Mixte", "0"=>"Homme et Femme"],
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ])
            ->add("wei_dateWEI","date",[
                'label' => "Date WEI",
                'format' => "yyyy-MM-dd"
            ])
            ->add("wei_produitInscriptionWEI","entity",[
                'class' => 'Cva\\GestionMembreBundle\\Entity\\Produit',
                'label' => "Inscription"
            ])
            ->add("wei_produitListePreWEI","entity",[
                'class' => 'Cva\\GestionMembreBundle\\Entity\\Produit',
                'label' => "Pré-Attente"
            ])
            ->add("wei_produitPreInscritsWEI","entity",[
                'class' => 'Cva\\GestionMembreBundle\\Entity\\Produit',
                'label' => "Pré-Inscription"
            ])
            ->add("wei_produitListeWEI","entity",[
                'class' => 'Cva\\GestionMembreBundle\\Entity\\Produit',
                'label' => "Attente"
            ])
            ->add("wei_produitRemboursementWEI","entity",[
                'class' => 'Cva\\GestionMembreBundle\\Entity\\Produit',
                'label' => "Remboursement"
            ])
            ->add("actions","form_actions",[
                'buttons' => [
                    'save' => ['type' => 'submit', 'options' => ['label' => 'button.save']],
                    'cancel' => ['type' => 'button', 'options' => ['label' => 'button.cancel']],
                ]
            ])
            ->getForm()->setData($d);

        $config->handleRequest($request);

        if($config->isValid()){
            $newConfig = array();
            foreach ($config->getData() as $k => $v) {
                $k = str_replace("_",".",$k);
                if($v instanceof Produit){
                    $v = $v->getId();
                } else if($v instanceof \DateTime){
                    $v = $v->format("Y-m-d");
                }
                $newConfig[$k] = strval($v);
            }
            $confs = $em->getRepository("BdEMainBundle:Config")->findAll();
            foreach ($confs as $c) {
                if(isset($newConfig[$c->getName()])){
                    $c->setValue($newConfig[$c->getName()]);
                    $em->persist($c);
                }
            }
            $em->flush();
            $this->addFlash("success","Configuration sauvegardé");
        }

        return array('form'=>$config->createView());
    }

    public function ajoutDetailsWEIAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $id = $_POST['id'];
        } else {
            $id = $_GET['id'];
        }


        $detailsWEI = $this->serviceMembre->GetDetailsByIdEtudiant($id);
        if ($detailsWEI == NULL) {
            $detailsWEI = new DetailsWEI();
        }

        $etu = $this->serviceMembre->GetEtudiantById($id);
        if (boolval($em->getRepository("BdEMainBundle:Config")->get("wei.bungMixtes"))) {
            $sexeEtu = -1;
        } elseif ($etu->getCivilite() == "M") {
            $sexeEtu = "M";
        } else {
            $sexeEtu = "F";
        }

        $form = $this->createForm(new DetailsWEIType($sexeEtu, $detailsWEI->getBus(), $detailsWEI->getBungalow()), $detailsWEI);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $bizuth = $this->serviceMembre->GetEtudiantById($request->request->get('id'));
                $detailsWEI->setIdEtudiant($bizuth);
                $em->persist($detailsWEI);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Details enregistres');
                return $this->redirect($this->generateUrl('bde_wei_inscription_rechercheBizuthWEI'));
            }
        }

        return $this->render('BdEWeiBundle:Default:ajoutDetailsWEI.html.twig', array('form' => $form->createView(), 'id' => $request->query->get('id')));
    }


    public function clearWEIAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Suppression des details
        $details = $this->get('cva_gestion_membre')->GetAllDetails();
        foreach($details as $detail)
        {
            $em->remove($detail);
        }

        //Suppression des bus
        $bus = $this->get('cva_gestion_membre')->GetAllBus();
        foreach($bus as $b)
        {
            $em->remove($b);
        }

        //Suppression des bung
        $bung = $this->get('cva_gestion_membre')->GetAllBung();
        foreach($bung as $bg)
        {
            $em->remove($bg);
        }

        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Clear');
        return $this->redirect($this->generateUrl('cva_gestion_membre_config'));

    }

    public function writeJSONWEIAction()
    {
        $em = $this->getDoctrine()->getManager();

        if(file_exists($this->fileConfigWEI))
        {
            $json = $this->get("doctrine.orm.entity_manager")->getRepository("BdEMainBundle:Config")->getConfig();
        }

        $json = $this->get('doctrine.orm.entity_manager')->getRepository("BdEMainBundle:Config")->getConfig();

        $json["nbMaxBizuths"] = $_GET['nbBizuths'];
        $json["dateWEI"] = $_GET['dateWEI'];
        $json["produitPreInscritsWEI"] = $_GET['produitPreInscritsWEI'];
        $json["produitInscriptionWEI"] = $_GET['produitInscriptionWEI'];
        $json["produitListeWEI"] = $_GET['produitListeWEI'];
        $json["produitListePreWEI"] = $_GET['produitListePreWEI'];
        $json["produitRemboursementWEI"] = $_GET['produitRemboursementWEI'];
        $json["bungMixtes"] = $_GET['bungMixtes'];

        $bizuthsInscrits=$this->get('cva_gestion_membre')->GetEtudiantByProduit($json["produitInscriptionWEI"]);
        $produitWEI = $this->get('cva_gestion_membre')->GetProduitById($json["produitInscriptionWEI"]);
        //die(var_dump(intval($json["nbMaxBizuths"])));
        if(sizeof($bizuthsInscrits)>$json["nbMaxBizuths"])
        {
            $this->get('session')->getFlashBag()->add('warning', 'Nombre max de bizuths < Nb de bizuths deja inscrits');
            return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
        }
        elseif(sizeof($bizuthsInscrits)==$json["nbMaxBizuths"])
        {
            $produitWEI->setDisponibilite("NON");
        }
        elseif(sizeof($bizuthsInscrits)<$json["nbMaxBizuths"])
        {
            $produitWEI->setDisponibilite("OUI");
        }
        $em->persist($produitWEI);
        $em->flush();
        file_put_contents($this->fileConfigWEI, json_encode($json));

        return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
    }

    public function exportAllWEIAction()
    {
        $enTetesExport = array('Numero etudiant','Raison sociale','Nom','Prenom','Date de naissance','Majeur','Mail', 'Tel','Bus','Bungalow','Remarque');
        if(file_exists($this->fileConfigWEI))
        {
            $json = $this->get("doctrine.orm.entity_manager")->getRepository("BdEMainBundle:Config")->getConfig();
            $idProduitInscritWEI=$json["produitInscriptionWEI"];
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($idProduitInscritWEI);

            //En-t�tes
            $exportCSV=implode(";", $enTetesExport);
            $exportCSV.="\r\n";

            //Le contenu
            foreach ($adherent as &$adh)
            {
                $exportCSV.=$adh["bizuth"]->getNumEtudiant().";";
                $exportCSV.=$adh["bizuth"]->getCivilite().";";
                $exportCSV.=$adh["bizuth"]->getName().";";
                $exportCSV.=$adh["bizuth"]->getFirstName().";";
                $exportCSV.=date_format($adh["bizuth"]->getBirthday(),'d/m/Y').";";
                $exportCSV.=$adh["majeur"].";";
                $exportCSV.=$adh["bizuth"]->getMail().";";
                $exportCSV.=$adh["bizuth"]->getTel().";";
                $exportCSV.=$adh["bus"].";";
                $exportCSV.=$adh["bung"].";";
                $exportCSV.=$adh["bizuth"]->getRemarque()."\r\n";
            }


            $response = new Response();
            $response->setContent($exportCSV);
            $response->headers->set('Content-Type','application/force-download');
            $response->headers->set('Content-disposition','filename="export.csv"');

            return $response;
        }
        else
        {
            $this->get('session')->getFlashBag()->add('warning', 'Renseignez le produit WEI avant export.');
            return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
        }
    }



}
