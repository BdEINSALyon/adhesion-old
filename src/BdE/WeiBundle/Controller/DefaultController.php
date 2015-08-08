<?php

namespace BdE\WeiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl("bde_wei_inscription_listeAttente"));
    }

    public function ajoutDetailsWEIAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bungMixtes = "";
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $bungMixtes = $json["bungMixtes"];
        }

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
        if ($bungMixtes == "OUI") {
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
                return $this->redirect($this->generateUrl('cva_gestion_membre_rechercheBizuthWEI'));
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
            $json = json_decode(file_get_contents($this->fileConfigWEI),true);
        }

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
            $json = json_decode(file_get_contents($this->fileConfigWEI),true);
            $idProduitInscritWEI=$json["produitInscriptionWEI"];
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($idProduitInscritWEI);

            //En-têtes
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
