<?php

namespace BdE\WeiBundle\Controller;

use BdE\WeiBundle\Entity\DetailsWEI;
use BdE\WeiBundle\Form\DetailsWEIType;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Paiement;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Service\ServiceMembre;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends Controller
{
    /**
     * @var ServiceMembre
     */
    private $serviceMembre;

    /**
     * @var string
     */
    private $fileConfigWEI = "../app/config/configWEI.txt";


    public function ajoutBizuthAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etudiant = new Etudiant();

        //Les bizuths sont au PC ;)
        $etudiant->setDepartement('PC');

        //En théorie ils sont dans l'année de leurs 18 ans
        $anneeCourante = getdate();
        $anneeMaj = $anneeCourante['year'] - 18;

        $etudiant->setBirthday(new DateTime($anneeMaj . "-01-24"));

        $form = $this->createForm(new EtudiantType(), $etudiant);

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $em->persist($etudiant);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Bizuth WEI ajoute');
                return $this->redirect('paiement?id=' . $etudiant->getId() . '&from=wei');
            }
        }

        return $this->render('BdEWeiBundle:Inscription:ajoutBizuthWei.html.twig', array('form' => $form->createView(),));
    }

    public function rechercheBizuthWEIAction(Request $request)
    {
        $adherent = array();
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $idProduitInscritWEI = $json["produitInscriptionWEI"];
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($idProduitInscritWEI);

            $nbPlacesRestantes = $json["nbMaxBizuths"] - sizeof($adherent);

            $this->get('session')->getFlashBag()->add('notice', 'Plus que ' . $nbPlacesRestantes . ' places restantes !');

        }

        return $this->render('BdEWeiBundle:Inscription:rechercheBizuthWEI.html.twig', array('adherent' => $adherent));
    }

    public function preInscritsAction(Request $request)
    {
        $adherent = array();
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $produitPreInscritsWEI = $json["produitPreInscritsWEI"];

            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitPreInscritsWEI);
            $nbPlacesRestantes = $json["nbMaxBizuths"] - sizeof($adherent);
            $this->get('session')->getFlashBag()->add('notice', 'Plus que ' . $nbPlacesRestantes . ' places restantes !');

        }

        return $this->render('BdEWeiBundle:Inscription:preInscritsWEI.html.twig',
            array('adherent' => $adherent,
                'produitPreInscritsWEI' => $produitPreInscritsWEI
            ));
    }

    public function listeAttenteAction(Request $request)
    {
        $adherent = array();
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $produitListeWEI = $json["produitListeWEI"];
            //die(var_dump($idProduitInscritWEI));
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitListeWEI);
        } else {
            exit;
        }

        return $this->render('BdEWeiBundle:Inscription:listeAttenteWEI.html.twig', array('adherent' => $adherent));
    }

    public function listeAttentePreAction(Request $request)
    {
        $adherent = array();
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $produitListeWEI = $json["produitListePreWEI"];
            //die(var_dump($idProduitInscritWEI));
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitListeWEI);
        } else {
            exit;
        }

        return $this->render('BdEWeiBundle:Inscription:listeAttentePreWEI.html.twig', array('adherent' => $adherent));
    }

    public function remboursementsAction(Request $request)
    {
        $adherent = array();
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $produitRemboursementWEI = $json["produitRemboursementWEI"];
            //die(var_dump($idProduitInscritWEI));
            $adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitRemboursementWEI);
        } else {
            exit;
        }

        return $this->render('BdEWeiBundle:Inscription:remboursementsWEI.html.twig',
            array('adherent' => $adherent,
                'produitRemboursementWEI' => $produitRemboursementWEI));
    }

    public function remplacerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idRemplace = $_GET['idRemplace'];
        $idRemplacant = $request->query->get('idRemplacant');
        $produitWEI = "";
        $produitRemboursementWEI = "";
        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $produitWEI = $this->get('cva_gestion_membre')->GetProduitById($json["produitInscriptionWEI"]);
            $produitRemboursementWEI = $this->get('cva_gestion_membre')->GetProduitById($json["produitRemboursementWEI"]);
        } else {
            exit;
        }

        $detailsWEIRemplacant = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($idRemplacant);
        if ($detailsWEIRemplacant != NULL) {
            $em->remove($detailsWEIRemplacant);
            $em->flush();
        }

        $detailsWEIRemplace = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($idRemplace);
        if ($detailsWEIRemplace != NULL) {
            $detailsWEIRemplace->setIdEtudiant($this->get('cva_gestion_membre')->GetEtudiantById($idRemplacant));
        }

        //On supprime l'inscription WEI
        $paiementsDuRemplace = $this->get('cva_gestion_membre')->GetPaiementEtudiant($idRemplace);
        foreach ($paiementsDuRemplace as $paie) {
            if (in_array($produitWEI, $paie->getProduits()->toArray())) {
                //die(var_dump("ty"));
                if (sizeof($paie->getProduits()) == 1) {
                    $em->remove($paie);
                } else if (sizeof($paie->getProduits()) > 1) {
                    $paie->removeProduit($produitWEI);
                }
            }
        }

        //On créé un remboursement
        $paiementRemboursement = new Paiement();
        $paiementRemboursement->setMoyenPaiement("Remplacement");
        $paiementRemboursement->setIdEtudiant($this->get('cva_gestion_membre')->GetEtudiantById($idRemplace));
        $paiementRemboursement->addProduit($produitRemboursementWEI);

        $em->persist($paiementRemboursement);
        $em->flush();

        return $this->redirect($this->generateUrl('cva_gestion_membre_editPaiement', array('id' => $request->query->get('idRemplacant'))));

    }

}
