<?php

namespace Cva\GestionMembreBundle\Controller;

use BdE\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Form\BusType;
use Cva\GestionMembreBundle\Form\BungalowType;
use Cva\GestionMembreBundle\Form\resetPasswordType;
use Cva\GestionMembreBundle\Form\ConnexionType;
use Cva\GestionMembreBundle\Form\ProduitType;
use Cva\GestionMembreBundle\Form\PaiementType;
use Cva\GestionMembreBundle\Form\UserType;
use Cva\GestionMembreBundle\Form\DetailsWEIType;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Produit;
use Cva\GestionMembreBundle\Entity\Paiement;
use Cva\GestionMembreBundle\Entity\DetailsWEI;
use Cva\GestionMembreBundle\Entity\Bus;
use Cva\GestionMembreBundle\Entity\Bungalow;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use \DateInterval;

class GestionMembreController extends Controller
{
    private $fileConfigWEI = "../app/config/configWEI.txt";
    private $fileConfigGeneral = "../app/config/configGeneral.txt";

    //La redirection depuis /
    public function cacaAction(Request $request)
    {
        return $this->redirect($this->generateUrl('cva_membership_students_current'));
    }

    public function configAction()
    {

        $allBus = $this->get('cva_gestion_membre')->GetAllBusAvecPlacesPrises();
        $allBung = $this->get('cva_gestion_membre')->GetAllBungAvecPlacesPrises();
        $allProduits = $this->get('cva_gestion_membre')->GetAllProduit();
        $nbMaxBizuths = "";
        $dateWEI = "";
        $produitInscriptionWEI = "";
        $produitPreInscritsWEI = "";
        $produitListeWEI = "";
        $produitListePreWEI = "";
        $produitRemboursementWEI = "";
        $bungMixtes = "";
        $produitsVA = array();

        if (file_exists($this->fileConfigWEI)) {
            $json = json_decode(file_get_contents($this->fileConfigWEI), true);
            $nbMaxBizuths = $json["nbMaxBizuths"];
            $dateWEI = $json["dateWEI"];
            $produitInscriptionWEI = $json["produitInscriptionWEI"];
            $produitPreInscritsWEI = $json["produitPreInscritsWEI"];
            $produitListeWEI = $json["produitListeWEI"];
            $produitListePreWEI = $json["produitListePreWEI"];
            $produitRemboursementWEI = $json["produitRemboursementWEI"];
            $bungMixtes = $json["bungMixtes"];

        }
        $produitsVA = $this->get('cva_gestion_membre')->GetProduitsVA();


        return $this->render('CvaGestionMembreBundle::config.html.twig',
            array(
                "allBus" => $allBus,
                "allBung" => $allBung,
                "allProduits" => $allProduits,
                "nbMaxBizuths" => $nbMaxBizuths,
                "dateWEI" => $dateWEI,
                "produitPreInscritsWEI" => $produitPreInscritsWEI,
                "produitInscriptionWEI" => $produitInscriptionWEI,
                "produitListeWEI" => $produitListeWEI,
                "produitListePreWEI" => $produitListePreWEI,
                "produitRemboursementWEI" => $produitRemboursementWEI,
                "bungMixtes" => $bungMixtes,
                "produitsVA" => $produitsVA
            )
        );
    }

    public function statsAction()
    {
        $paymentsRepository = $this->get("doctrine.orm.entity_manager")->getRepository("CvaGestionMembreBundle:Payment");

        //Ventes Mois
        $ventesMois = $paymentsRepository->countMonthSales();
        $message = ($ventesMois < 50 ? "C'est la loose Michel !" : ($ventesMois < 300 ? "Honnete." : ($ventesMois < 800 ? "Pas mal du tout !" : "Nickel, on va pouvoir combler le trou des 24 !")));

        //Stats par produits
        $prods = $this->get('cva_gestion_membre')->GetAllProduitDispo();
        $ventesProds = array();
        foreach ($prods as $prod) {
            $ventes = count($this->get('cva_gestion_membre')->GetEtudiantByProduit($prod->getId()));
            $magot = $prod->getPrice() * $ventes;
            $ventesProds[] = array('prod' => $prod, 'vendus' => $ventes, 'magot' => $magot);
        }

        //Stats par années
        $venteAnnee = array();
        $annees = array(1, 2, 3, 4, 5, '3CYCLE', 'Personnel', 'Autre');
        foreach ($annees as &$annee) {
            $venteAnnee[$annee] = 0;
        }

        //Stats par depart
        $venteDepart = array();
        $departs = array('PC', 'GEN', 'GCU', 'GI', 'GMC', 'GMD', 'GMPP', 'GE', 'IF', 'TC', 'BB', 'BIM', 'SGM');
        foreach ($departs as &$depart) {
            $venteDepart[$depart] = 0;
        }

        $adherents = $this->get('cva_gestion_membre')->GetActuelsAdherents();
        foreach ($adherents as &$bizuth) {
            $venteAnnee[$bizuth->getAnnee()]++;
            if ($bizuth->getDepartement()) {
                $venteDepart[$bizuth->getDepartement()]++;
            }
        }


        return $this->render('CvaGestionMembreBundle::stats.html.twig', array('venteProds' => $ventesProds, 'venteAnnee' => $venteAnnee, 'venteDepart' => $venteDepart, 'ventesMois' => $ventesMois, 'message' => $message));
    }

    public function is_memberAction(Request $request)
    {
        $numEtu = $request->query->get('numEtu');
        $adh = $this->get('cva_gestion_membre')->IsCurrentAdherent($numEtu);

        $response = new JsonResponse();
        $response->setData(array(
                'member' => $adh == null ? false : true)
        );
        return $response;
    }

    public function assoCheckAction(Request $request)
    {
        return $this->render('CvaGestionMembreBundle::checkAsso.html.twig', array());
    }


}
