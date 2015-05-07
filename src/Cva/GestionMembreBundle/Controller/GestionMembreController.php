<?php

namespace Cva\GestionMembreBundle\Controller;

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
use Cva\GestionMembreBundle\Entity\User;
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
		return $this->redirect($this->generateUrl('cva_gestion_membre_adherent'));
	}

	public function exportCSVAction(Request $request)
	{
		$response = new Response();
		$response->setContent($request->request->get('csvText'));
		$response->headers->set('Content-Type','application/force-download');
		$response->headers->set('Content-disposition','filename="export.csv"');
		
		return $response;
	}

	public function profilAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$form = $this->createForm(new resetPasswordType());
		if($request->isMethod('POST'))
		{
			$form->bind($request);

			if ($form->isValid()) 
			{	
				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($user);
				$oldPassword = $encoder->encodePassword($form->get('oldPassword')->getData() , $user->getSalt());
				$em = $this->getDoctrine()->getManager();

				if(is_null($form->get('oldPassword')->getData()))
				{
					$user->setUsername($form->get('username')->getData());
					$em->persist($user);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Profil modifie');
				}
				else if($oldPassword == $user->getPassword())
				{
					$user->setUsername($form->get('username')->getData());
					$newPassword = $encoder->encodePassword($form->get('newPassword')->getData() , $user->getSalt());
					$user->setPassword($newPassword);
					$em->persist($user);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Profil modifie');
				}
				else if ($oldPassword !== $user->getPassword())
				{
					$this->get('session')->getFlashBag()->add('warning', 'Le mot de passe renseigne ne correspond pas a votre mot de passe');
					return $this->render('CvaGestionMembreBundle::profil.html.twig', array('form' => $form->createView(),));
				}		
				
			}
		}
		
		if (!$form->isBound())
		{
			$form->setData(array('username' => $user->getUsername()));
		}
		
		return $this->render('CvaGestionMembreBundle::profil.html.twig', array('form' => $form->createView(),));
	}

	//Adherents
	
	public function ajoutAdherentAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$etudiant = new Etudiant();
		$etudiant->setDepartement('PC');
		$form = $this->createForm(new EtudiantType(), $etudiant);

		if($request->isMethod('POST'))
		{
			//die(var_dump('coucou'));
			$form->bind($request);

			if ($form->isValid()) 
			{
				if($form->get('Valider')->isClicked())
				{
					$em->persist($etudiant);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Etudiant ajoutÃ©');

					//Affichage mineur
					$anniv = $etudiant->getBirthday();
					$inter = $anniv->diff(new DateTime());
					$age = $inter->format('%y');
					if($age<18)
					{
						$this->get('session')->getFlashBag()->add('warning', 'Cet etudiant est mineur !');
					}			

					return $this->redirect('paiement?id=' . $etudiant->getId());
				}
			}
		}

		return $this->render('CvaGestionMembreBundle::AjoutAdherent.html.twig', array('form' => $form->createView(),));
	}

	public function paiementAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$produits = $this->get('cva_gestion_membre')->GetAllProduitDispo();
		$paiement = new Paiement();
		$paiementType = new PaiementType($produits);
		$form = $this->createForm($paiementType, $paiement);

		if($request->isMethod('POST'))
		{
			$form->bind($request);

			if ($form->isValid()) 
			{

				if(sizeof($form->get('Produits')->getData()) == 0) {

					$this->get('session')->getFlashBag()->add('warning', 'Vous devez choisir au moins un produit');
					return $this->redirect($this->generateUrl('cva_gestion_membre_editPaiement', array('id' => $request->request->get('id'))));
				} 
				foreach($produits as $prod)
				{
					foreach($form->get('Produits')->getData() as $desc)
					{
						if (strcmp($desc, $prod->getDescription()) == 0)
						{
							//On vérifie que l'étudiant ne possède pas déjà le produit
							if($this->get('cva_gestion_membre')->EtudiantAlreadyGotProduct($request->request->get('id'),$prod)==true)
							{
								$this->get('session')->getFlashBag()->add('warning', 'Cet etudiant possede deja ce produit');
								return $this->redirect($this->generateUrl('cva_gestion_membre_editPaiement', array('id' => $request->request->get('id'))));
							}
							$paiement->addProduit($prod);
						}
					}
				}
				$etudiant = $this->get('cva_gestion_membre')->GetEtudiantById($request->request->get('id'));
				$paiement->setIdEtudiant($etudiant);
				$em->persist($paiement);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Paiement effectuÃ©');

				//Test max bizuths atteint dans le cas du WEI
				if(file_exists($this->fileConfigWEI))
				{
					$json = json_decode(file_get_contents($this->fileConfigWEI),true);
					$idProduitInscritWEI=$json["produitInscriptionWEI"];
					$idProduitPreInscritWEI=$json["produitPreInscritsWEI"];
					$produitListeWEI=$json["produitListeWEI"];
					$produitListePreWEI=$json["produitListePreWEI"];
					$produitRemboursementWEI=$json["produitRemboursementWEI"];
					$nbMaxBizuths=$json["nbMaxBizuths"];
					$produitWEI = $this->get('cva_gestion_membre')->GetProduitById($idProduitInscritWEI);
					$produitPreWEI = $this->get('cva_gestion_membre')->GetProduitById($idProduitPreInscritWEI);
					$produitListeAttenteWEI = $this->get('cva_gestion_membre')->GetProduitById($produitListeWEI);
					$produitListeAttentePreWEI = $this->get('cva_gestion_membre')->GetProduitById($produitListePreWEI);
					$produitDesWEI = $this->get('cva_gestion_membre')->GetProduitById($produitRemboursementWEI);
					
					//Si Inscrits/Pre-Inscrits = Max activer les liste attente
					if(in_array($produitWEI, $paiement->getProduits()->toArray()))
					{
						$bizuthsInscrits=$this->get('cva_gestion_membre')->GetEtudiantByProduit($idProduitInscritWEI);
						if(sizeof($bizuthsInscrits)==$nbMaxBizuths)
						{
							$produitWEI->setDisponibilite("NON");
							$produitListeAttenteWEI->setDisponibilite("OUI");
							$em->persist($produitWEI);
							$em->persist($produitListeAttenteWEI);
							$em->flush();
						}
					}
					if(in_array($produitPreWEI, $paiement->getProduits()->toArray()))
					{
						$bizuthsInscrits=$this->get('cva_gestion_membre')->GetEtudiantByProduit($idProduitPreInscritWEI);
						if(sizeof($bizuthsInscrits)==$nbMaxBizuths)
						{
							$produitPreWEI->setDisponibilite("NON");
							$produitListeAttentePreWEI->setDisponibilite("OUI");
							$em->persist($produitPreWEI);
							$em->persist($produitListeAttentePreWEI);
							$em->flush();
						}
					}
					if(in_array($produitDesWEI, $paiement->getProduits()->toArray()))
					{
						if($this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($etudiant->getId())<>NULL)
						{
							$details=$this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($etudiant->getId());
							$em->remove($details);	
							$em->flush();				
						}
					}

					//Si liste attente Inscrits ou Pre-Inscrits : donner place dans liste
					if(in_array($produitListeAttenteWEI, $paiement->getProduits()->toArray()))
					{
						if($this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($etudiant->getId())==NULL)
						{
							$maxListeAttente = $this->get('cva_gestion_membre')->GetMaxListeAttente();
							$detailsWEICourant = new DetailsWEI();
							$detailsWEICourant->setIdEtudiant($etudiant);
							$detailsWEICourant->setPlaceListeAttente($maxListeAttente[1]+1);						
							$em->persist($detailsWEICourant);
							$em->flush();						
						}
					}
					if(in_array($produitListeAttentePreWEI, $paiement->getProduits()->toArray()))
					{
						$maxListeAttente = $this->get('cva_gestion_membre')->GetMaxListeAttente();
						$detailsWEICourant = new DetailsWEI();
						$detailsWEICourant->setIdEtudiant($etudiant);
						$detailsWEICourant->setPlaceListeAttente($maxListeAttente[1]+1);						
						$em->persist($detailsWEICourant);
						$em->flush();						
					}
				}
				$produitsVA = $this->get('cva_gestion_membre')->GetProduitsVA();
				$prodsVA = array();
				foreach ($produitsVA as &$prod) {
					$prodsVA[] = $this->get('cva_gestion_membre')->GetProduitById($prod);					 
				}
				$prodsVAin = array_intersect($paiement->getProduits()->toArray(),$prodsVA);
				if(!empty($prodsVAin))
				{
					$message = \Swift_Message::newInstance()
						->setSubject('Adhésion Vie Associative')
						->setContentType('text/html')
						->setCharset('utf-8')
						->setFrom(array('bde.adhesion@insa-lyon.fr'=> 'Appli VA'))
						->setTo($etudiant->getMail());

						$today = new DateTime();
						$interval = new DateInterval('P3M');
						$troisMoisAvant=$today->sub($interval);


						if($etudiant->getDateCreation()<$troisMoisAvant)
							$message->setBody($this->renderView('CvaGestionMembreBundle::mailAnciens.html.twig', array('prenomBizuth' => $etudiant->getFirstName())));
				       	else
				       		$message->setBody($this->renderView('CvaGestionMembreBundle::mailBizuths.html.twig', array('prenomBizuth' => $etudiant->getFirstName())));

						$this->get('mailer')->send($message);
					//$this->get('cva_gestion_membre')->EnvoiMailAdherent($etudiant);

				}			

				return $this->redirect($this->generateUrl('cva_gestion_membre_ajoutAdherent'));
			}
		}
		return $this->render('CvaGestionMembreBundle::paiement.html.twig', array('from' => $request->request->get('from'),'form' => $form->createView(), 'id' => $request->query->get('id')));
	}
	
	public function editPaiementAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();		
		$paiementsEtud = $this->get('cva_gestion_membre')->GetPaiementEtudiant($request->query->get('id'));
		$produits = $this->get('cva_gestion_membre')->GetAllProduitDispo();
		$paiement = new Paiement();
		$paiementType = new PaiementType($produits);
		$form = $this->createForm($paiementType, $paiement);

		return $this->render('CvaGestionMembreBundle::paiement.html.twig', array('form' => $form->createView(), 'id' => $request->query->get('id'), 'paiementsEtud' => $paiementsEtud));
	}
	
	public function deletePaiementAction(Request $request) {
		
		$idEtu = $request->query->get('idEtu');
		$em = $this->getDoctrine()->getManager();		
		$paiement = $this->get('cva_gestion_membre')->GetPaiementById($request->query->get('idPaiement'));
		if(sizeof($paiement->getProduits())==1)
		{
			$em->remove($paiement);
		}
		else if(sizeof($paiement->getProduits())>1)
		{
			$produit = $this->get('cva_gestion_membre')->GetProduitById($request->query->get('idProduit'));
			$paiement->removeProduit($produit);
		}

		if(file_exists($this->fileConfigWEI))
		{
			$json = json_decode(file_get_contents($this->fileConfigWEI),true);
			$idProduitInscritWEI=$json["produitInscriptionWEI"];

			if($request->query->get('idProduit')==$idProduitInscritWEI)
			{
				//On est en train de supprimer une inscription au WEI
				//Il faut donc supprimer son DetailsWEI aussi.

				$detailWEI=$this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($idEtu);
				if($detailWEI!=NULL)
				{
					$bus=$detailWEI->getBus();
					$bung=$detailWEI->getBungalow();
					
					$em->remove($detailWEI);
				}

				//Et remettre la dispo à OUI
				$produitWEI=$this->get('cva_gestion_membre')->GetProduitById($idProduitInscritWEI);
				$produitWEI->setDisponibilite("OUI");
			}
			
		}


		$em->flush();
		$this->get('session')->getFlashBag()->add('notice', 'Modification enregistree');
		return $this->redirect($this->generateUrl('cva_gestion_membre_editPaiement',array('id'=>$idEtu)));
	}
	
	public function editEtudiantAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();		
		$etudiant = $this->get('cva_gestion_membre')->GetEtudiantById($request->query->get('id'));
		
		$form = $this->createForm(new EtudiantType(), $etudiant);
		
		if($request->isMethod('POST'))
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em->persist($etudiant);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Etudiant modifiÃ©');

				//Affichage mineur
				$anniv = $etudiant->getBirthday();
				$inter = $anniv->diff(new DateTime());
				$age = $inter->format('%y');
				if($age<18)
				{
					$this->get('session')->getFlashBag()->add('warning', 'Cet etudiant est mineur !');
				}
				
				if($form->get('Prod')->isClicked())
				{
					return $this->redirect($this->generateUrl('cva_gestion_membre_editPaiement',array('id'=>$etudiant->getId())));
				}
				else
				{
					return $this->redirect($this->generateUrl('cva_gestion_membre_adherent'));
				}
			}
		}
		
		return $this->render('CvaGestionMembreBundle::editetudiant.html.twig', array('form' => $form->createView(), 'id' => $request->query->get('id')));
	}
	
	public function deleteAdherentAction(Request $request) {

		$em = $this->getDoctrine()->getManager();		
		$adh = $this->get('cva_gestion_membre')->GetEtudiantById($request->query->get('id'));
		$paiements= $this->get('cva_gestion_membre')->GetPaiementEtudiant($request->query->get('id'));
		$details = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($request->query->get('id'));

		foreach ($paiements as &$value) {
			$em->remove($value);
		}
		if($details){
			$em->remove($details);
		}
		
		$em->remove($adh);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice', 'Adherent supprimÃ©');
		return $this->redirect($this->generateUrl('cva_gestion_membre_adherent'));
	}

	public function voirDetailsAction(Request $request)
	{
		$idEtu = $request->query->get('idEtu');
		$remplacer="";

		if($request->query->get('remplacer')!=NULL)
		{
			$remplacer=$request->query->get('remplacer');
		}

		if(isset($idEtu))
		{
			$etudiantRecherche = $this->get('cva_gestion_membre')->GetEtudiantById($idEtu);
			$remplacantsWEI = $this->get('cva_gestion_membre')->GetRemplacantsWEI($etudiantRecherche->getCivilite()); 
			$paiements = $this->get('cva_gestion_membre')->GetPaiementEtudiant($etudiantRecherche->getId());
			if ($paiements)
			{
				foreach ($paiements as $paiement)
				{
					foreach ($paiement->getProduits() as $prod)
					{
						$produits[] = $prod;
					}
				}
			}
			else
			{
				$produits = new Produit();
				$produits->setDescription("Aucun");
			}
			
			return $this->render('CvaGestionMembreBundle::voirDetails.html.twig', 
				array('etu' => $etudiantRecherche, 
					'produits' => $produits,
					'remplacer' => $remplacer,
					'remplacantsWEI' => $remplacantsWEI));
		}
	}
	
	public function adherentAction(Request $request)
	{
		$allAdherents=array();
		$allAdherents = $this->get('cva_gestion_membre')->GetActuelsAdherents();
		
		return $this->render('CvaGestionMembreBundle::rechercheAdherent.html.twig', array('adherent' => $allAdherents, 'type' => 'Actuels') );
	}

	public function anciensAction(Request $request)
	{
		$allAdherents=array();

		$allAdherents = $this->get('cva_gestion_membre')->GetAnciensAdherents();
		
		return $this->render('CvaGestionMembreBundle::rechercheAdherent.html.twig', array('adherent' => $allAdherents, 'type' => 'Anciens') );
	}
	
	//WEI
	public function ajoutBizuthWEIAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$etudiant = new Etudiant();

		//Les bizuths sont au PC ;)
		$etudiant->setDepartement('PC');

		//En théorie ils sont dans l'année de leurs 18 ans
		$anneeCourante = getdate();
		$anneeMaj = $anneeCourante['year']-18;

		$etudiant->setBirthday(new DateTime($anneeMaj."-01-24"));		

		$form = $this->createForm(new EtudiantType(), $etudiant);

		if($request->isMethod('POST'))
		{
			$form->bind($request);

			if ($form->isValid()) 
			{
				$em->persist($etudiant);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Bizuth WEI ajoute');
				return $this->redirect('paiement?id=' . $etudiant->getId().'&from=wei');		}
			}

			return $this->render('CvaGestionMembreBundle::ajoutBizuthWei.html.twig', array('form' => $form->createView(),));
		}

		public function rechercheBizuthWEIAction(Request $request)
		{
			$adherent=array();
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$idProduitInscritWEI=$json["produitInscriptionWEI"];
				$adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($idProduitInscritWEI);

				$nbPlacesRestantes = $json["nbMaxBizuths"]-sizeof($adherent);

				$this->get('session')->getFlashBag()->add('notice', 'Plus que '.$nbPlacesRestantes.' places restantes !');

			}

			return $this->render('CvaGestionMembreBundle::rechercheBizuthWEI.html.twig', array('adherent' => $adherent) );
		}

		public function preInscritsAction(Request $request)
		{
			$adherent=array();
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$produitPreInscritsWEI=$json["produitPreInscritsWEI"];

				$adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitPreInscritsWEI);
				$nbPlacesRestantes = $json["nbMaxBizuths"]-sizeof($adherent);
				$this->get('session')->getFlashBag()->add('notice', 'Plus que '.$nbPlacesRestantes.' places restantes !');

			}

			return $this->render('CvaGestionMembreBundle::preInscritsWEI.html.twig', 
				array('adherent' => $adherent,
					  'produitPreInscritsWEI' =>$produitPreInscritsWEI
					  ) );
		}

		public function listeAttenteAction(Request $request)
		{
			$adherent=array();
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$produitListeWEI=$json["produitListeWEI"];
				//die(var_dump($idProduitInscritWEI));
				$adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitListeWEI);
			}

			return $this->render('CvaGestionMembreBundle::listeAttenteWEI.html.twig', array('adherent' => $adherent) );
		}

		public function listeAttentePreAction(Request $request)
		{
			$adherent=array();
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$produitListeWEI=$json["produitListePreWEI"];
				//die(var_dump($idProduitInscritWEI));
				$adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitListeWEI);
			}

			return $this->render('CvaGestionMembreBundle::listeAttentePreWEI.html.twig', array('adherent' => $adherent) );
		}

		public function remboursementsAction(Request $request)
		{
			$adherent=array();
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$produitRemboursementWEI=$json["produitRemboursementWEI"];
				//die(var_dump($idProduitInscritWEI));
				$adherent = $this->get('cva_gestion_membre')->GetBizuthWEIAvecDetails($produitRemboursementWEI);
			}

			return $this->render('CvaGestionMembreBundle::remboursementsWEI.html.twig', 
				array('adherent' => $adherent,
					'produitRemboursementWEI' =>$produitRemboursementWEI) );
		}

		public function remplacerAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$idRemplace = $_GET['idRemplace'];
			$idRemplacant = $request->query->get('idRemplacant');
			$produitWEI="";
			$produitRemboursementWEI="";
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$produitWEI=$this->get('cva_gestion_membre')->GetProduitById($json["produitInscriptionWEI"]);
				$produitRemboursementWEI=$this->get('cva_gestion_membre')->GetProduitById($json["produitRemboursementWEI"]);
			}

			$detailsWEIRemplacant = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($idRemplacant);
			if($detailsWEIRemplacant!=NULL)
			{
				$em->remove($detailsWEIRemplacant);
				$em->flush();
			}

			$detailsWEIRemplace = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($idRemplace);
			if($detailsWEIRemplace!=NULL)
			{
				$detailsWEIRemplace->setIdEtudiant($this->get('cva_gestion_membre')->GetEtudiantById($idRemplacant));
			}

			//On supprime l'inscription WEI
			$paiementsDuRemplace = $this->get('cva_gestion_membre')->GetPaiementEtudiant($idRemplace);
			foreach ($paiementsDuRemplace as $paie)
			{
				if(in_array($produitWEI, $paie->getProduits()->toArray()))
				{
					//die(var_dump("ty"));
					if(sizeof($paie->getProduits())==1)
					{
						$em->remove($paie);
					}
					else if(sizeof($paie->getProduits())>1)
					{
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

		public function ajoutDetailsWEIAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$bungMixtes="";
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$bungMixtes=$json["bungMixtes"];
			}

			if($request->isMethod('POST'))
			{
				$id = $_POST['id'];
			}
			else
			{
				$id = $_GET['id'];
			}

			$detailsWEI = $this->get('cva_gestion_membre')->GetDetailsByIdEtudiant($id);
			if($detailsWEI==NULL)
			{ 
				$detailsWEI = new DetailsWEI();
			}

			$etu = $this->get('cva_gestion_membre')->GetEtudiantById($id);
			if($bungMixtes=="OUI")
			{
				$sexeEtu=-1;
			}
			elseif($etu->getCivilite()=="M")
			{
				$sexeEtu="M";
			}
			else
			{
				$sexeEtu="F";
			}

			$form = $this->createForm(new DetailsWEIType($sexeEtu,$detailsWEI->getBus(),$detailsWEI->getBungalow()), $detailsWEI);

			if($request->isMethod('POST'))
			{
				$form->bind($request);

				if ($form->isValid()) 
				{
					$bizuth=$this->get('cva_gestion_membre')->GetEtudiantById($request->request->get('id'));
					$detailsWEI->setIdEtudiant($bizuth);
					$em->persist($detailsWEI);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Details enregistres');
					return $this->redirect($this->generateUrl('cva_gestion_membre_rechercheBizuthWEI'));
				}
			}

			return $this->render('CvaGestionMembreBundle::ajoutDetailsWEI.html.twig', array('form' => $form->createView(),'id' => $request->query->get('id')));
		}
	//Utilisateurs
		public function addUserAction(Request $request)
		{

			$em = $this->getDoctrine()->getManager();
			$user = new User();
			$form = $this->createForm(new UserType(), $user);
			
			if($request->isMethod('POST'))
			{
				$form->bind($request);

				if ($form->isValid()) 
				{
					$factory = $this->get('security.encoder_factory');

					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
					$user->setPassword($password);
					$em->persist($user);
					$em->flush();

					$this->get('session')->getFlashBag()->add('notice', 'Utilisateur ajoutÃ©');
					return $this->redirect($this->generateUrl('cva_gestion_membre_addUser'));
				}
			}
			
			
			return $this->render('CvaGestionMembreBundle::ajoutUser.html.twig', array('form' => $form->createView(),));

		}

		public function editUserAction(Request $request)
		{
			$repository = $this->getDoctrine()->getRepository('CvaGestionMembreBundle:User');
			$myName=$this->get('security.context')->getToken()->getUser()->getUserName();
			$superAdmin = "a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}";

			$query = $repository->createQueryBuilder('u')
			->where('u.username <> :myName AND u.roles<> :superAdmin')
			->setParameter('myName', $myName)
			->setParameter('superAdmin', $superAdmin)
			->getQuery();

			$users = $query->getResult();

			return $this->render('CvaGestionMembreBundle::editUser.html.twig', array('user' => $users) );
		}

		public function modifUserAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();		
			$user = $this->get('cva_gestion_membre')->GetUserById($request->query->get('id'));

			$form = $this->createForm(new UserType(array()), $user);

			if($request->isMethod('POST'))
			{
				$form->bind($request);
				if ($form->isValid()) 
				{
					$factory = $this->get('security.encoder_factory');

					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
					$user->setPassword($password);

					$em->persist($user);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Utilisateur modifiÃ©');
					return $this->redirect($this->generateUrl('cva_gestion_membre_modifUser'));
				}
			}

			return $this->render('CvaGestionMembreBundle::modificationUser.html.twig', array('form' => $form->createView(), 'id' => $request->query->get('id')));
		}

		public function deleteUserAction(Request $request) {

			$em = $this->getDoctrine()->getManager();		
			$user = $this->get('cva_gestion_membre')->GetUserById($request->query->get('id'));

			$em->remove($user);
			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Utilisateur supprimÃ©');
			return $this->redirect($this->generateUrl('cva_gestion_membre_editUser'));
		}

	//Produits
		public function addProduitAction(Request $request)
		{

			$em = $this->getDoctrine()->getManager();
			$produit = new Produit();
			
			$produit->setDisponibilite('OUI');
			$form = $this->createForm(new ProduitType(), $produit);
			
			if($request->isMethod('POST'))
			{
				$form->bind($request);


				if ($form->isValid()) 
				{
					$em->persist($produit);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Produit ajoutÃ©');
					return $this->redirect($this->generateUrl('cva_gestion_membre_addProduit'));
				}
			}
			
			
			return $this->render('CvaGestionMembreBundle::ajoutProduit.html.twig', array('form' => $form->createView(),));

		}

		public function deleteProduitAction(Request $request) {

			$em = $this->getDoctrine()->getManager();		
			$product = $this->get('cva_gestion_membre')->GetProduitById($request->query->get('id'));

			$em->remove($product);
			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Produit supprimÃ©');
			return $this->redirect($this->generateUrl('cva_gestion_membre_tableauProduits'));
		}

		public function tableauProduitsAction(Request $request)
		{
			$repository = $this->getDoctrine()->getRepository('CvaGestionMembreBundle:Produit');
			
			$products = $repository->findAll();

			return $this->render('CvaGestionMembreBundle::tableauProduits.html.twig', array('produit' => $products) );
		}

		public function editProduitAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();		
			$product = $this->get('cva_gestion_membre')->GetProduitById($request->query->get('id'));

			$form = $this->createForm(new ProduitType(array()), $product);

			if($request->isMethod('POST'))
			{
				$form->bind($request);
				if ($form->isValid()) 
				{			
					$em->persist($product);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Produit modifiÃ©');
					return $this->redirect($this->generateUrl('cva_gestion_membre_editProduit'));
				}
			}

			return $this->render('CvaGestionMembreBundle::editProduit.html.twig', array('form' => $form->createView(), 'id' => $request->query->get('id')));
		}

    //Others
		
		public function loginAction()
		{
		// Si le visiteur est déjà identifié, on le redirige vers l'accueil
			if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
				return $this->redirect($this->generateUrl('cva_gestion_membre_adherent'));
			}

			$request = $this->getRequest();
			$session = $request->getSession();

		// On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
			if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
			} else {
				$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
				$session->remove(SecurityContext::AUTHENTICATION_ERROR);
			}

			return $this->render('CvaGestionMembreBundle::index.html.twig', array(
		  // Valeur du précédent nom d'utilisateur entré par l'internaute
				'last_username' => $session->get(SecurityContext::LAST_USERNAME),
				'error'         => $error,
				));
		}

		public function getAction( Request $request )
		{
			$date = getdate();
			$annee = $date['year'];
			if(isset($_GET['numEtu']))
			{
				$prod = $this->get('cva_gestion_membre')->GetProduitEtudiant($request->request->get('numEtu'));
				echo "coucou";
			//traiement sur le nom pour check
				if ( count($prod) > 0)
				{
					foreach ($prod as $p)
					{
						if (preg_match("#^VA".$annee."#", "p"))
						{
							$result = json_encode("true");
						}
						else
						{
							$result = json_encode("false");
						}
					}
				}
				else
				{
					$result = json_encode("false");				
				}
			}
			else
			{
				$result = json_encode("false");
			}
			echo $result;
		}

		public function configAction()
		{

			$allBus = $this->get('cva_gestion_membre')->GetAllBusAvecPlacesPrises();
			$allBung = $this->get('cva_gestion_membre')->GetAllBungAvecPlacesPrises();
			$allProduits = $this->get('cva_gestion_membre')->GetAllProduit();
			$nbMaxBizuths="";
			$dateWEI="";
			$produitInscriptionWEI="";
			$produitPreInscritsWEI="";
			$produitListeWEI="";
			$produitListePreWEI="";
			$produitRemboursementWEI="";
			$bungMixtes="";
			$produitsVA=array();
			
			if(file_exists($this->fileConfigWEI))
			{
				$json = json_decode(file_get_contents($this->fileConfigWEI),true);
				$nbMaxBizuths=$json["nbMaxBizuths"];
				$dateWEI=$json["dateWEI"];
				$produitInscriptionWEI=$json["produitInscriptionWEI"];
				$produitPreInscritsWEI=$json["produitPreInscritsWEI"];
				$produitListeWEI=$json["produitListeWEI"];
				$produitListePreWEI=$json["produitListePreWEI"];
				$produitRemboursementWEI=$json["produitRemboursementWEI"];
				$bungMixtes=$json["bungMixtes"];

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
			$adherent=array();
			$enTetesExport = array('Numero etudiant','Raison sociale','Nom','Prenom','Date de naissance','Majeur','Mail', 'Tel','Bus','Bungalow','Remarque');
			$exportCSV = "";
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

		public function writeJSONGeneralAction()
		{
			
			if(file_exists($this->fileConfigGeneral))
			{
				$json = json_decode(file_get_contents($this->fileConfigGeneral),true);
			}

			$json["produitsVA"] = $_GET['produitsVA'];
			file_put_contents($this->fileConfigGeneral, json_encode($json));

			return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
		}

		public function createMultipleBusAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$nbBus = $_GET['nbBus'];

			for ($i = 0; $i < $nbBus; $i++) {
				$bus = new Bus();
				$bus->setNom("ChangeMoi");
				$bus->setNbPlaces(1000);

				$em->persist($bus);
				$em->flush();
			}

			return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
		}

		public function ajoutBusAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$bus = new Bus();
			$form = $this->createForm(new BusType(), $bus);

			if($request->isMethod('POST'))
			{
				$form->bind($request);

				if ($form->isValid()) 
				{
					$em->persist($bus);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Bus ajoutÃ©');

					return $this->redirect($this->generateUrl('cva_gestion_membre_config'));


				}
			}

			return $this->render('CvaGestionMembreBundle::AjoutBus.html.twig', array('form' => $form->createView(),));
		}

		public function editBusAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();		
			$bus = $this->get('cva_gestion_membre')->GetBusById($request->query->get('idBus'));

			$form = $this->createForm(new BusType(), $bus);

			if($request->isMethod('POST'))
			{
				$form->bind($request);
				if ($form->isValid()) 
				{
				//Test pour vérifier qu'on ne donne pas une valeur de places max inférieure au nb de places déja prises
					if($bus->getNbPlaces()<$this->get('cva_gestion_membre')->GetNbDetailsByIdBus($bus->getId()))
					{
						$this->get('session')->getFlashBag()->add('warning', 'Vous devez d\'abord retirer des personnes de ce bus !' );
					}
					else
					{
						$em->persist($bus);
						$em->flush();
						$this->get('session')->getFlashBag()->add('notice', 'Bus modifiÃ©');
					}
					return $this->redirect($this->generateUrl('cva_gestion_membre_config'));

				}
			}

			return $this->render('CvaGestionMembreBundle::editBus.html.twig', array('form' => $form->createView(), 'idBus' => $request->query->get('idBus')));
		}

		public function deleteBusAction(Request $request) {

			$em = $this->getDoctrine()->getManager();		
			$bus = $this->get('cva_gestion_membre')->GetBusById($request->query->get('id'));

			$nbDetails = $this->get('cva_gestion_membre')->GetNbDetailsByIdBus($request->query->get('id'));

			if($nbDetails>0)
			{
				$this->get('session')->getFlashBag()->add('warning', 'Ce bus n\'est pas vide !');
				return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
			}

			$em->remove($bus);
			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Bus supprimÃ©');
			return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
		}

		public function createMultipleBungAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$nbBung = $_GET['nbBung'];

			for ($i = 0; $i < $nbBung; $i++) {
				$bungalow = new Bungalow();
				$bungalow->setNom("ChangeMoi");
				$bungalow->setNbPlaces(6);

				$em->persist($bungalow);
				$em->flush();
			}

			return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
		}

		public function ajoutBungAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();
			$bungalow = new Bungalow();
			$form = $this->createForm(new BungalowType(), $bungalow);

			if($request->isMethod('POST'))
			{
				$form->bind($request);

				if ($form->isValid()) 
				{
					$em->persist($bungalow);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Bungalow ajoutÃ©');

					return $this->redirect($this->generateUrl('cva_gestion_membre_config'));


				}
			}

			return $this->render('CvaGestionMembreBundle::AjoutBung.html.twig', array('form' => $form->createView(),));
		}

		public function editBungAction(Request $request)
		{
			$em = $this->getDoctrine()->getManager();		
			$bungalow = $this->get('cva_gestion_membre')->GetBungById($request->query->get('idBung'));

			$form = $this->createForm(new BungalowType(), $bungalow);

			if($request->isMethod('POST'))
			{
				$form->bind($request);
				if ($form->isValid()) 
				{
				//Test pour vérifier qu'on ne donne pas une valeur de places max inférieure au nb de places déja prises
					if($bungalow->getNbPlaces()<$this->get('cva_gestion_membre')->GetNbDetailsByIdBung($bungalow->getId()))
					{
						$this->get('session')->getFlashBag()->add('warning', 'Vous devez d\'abord retirer des personnes de ce bungalow !' );
					}
					else
					{
						$em->persist($bungalow);
						$em->flush();
						$this->get('session')->getFlashBag()->add('notice', 'Bungalow modifiÃ©');
					}
					return $this->redirect($this->generateUrl('cva_gestion_membre_config'));

				}
			}

			return $this->render('CvaGestionMembreBundle::editBung.html.twig', array('form' => $form->createView(), 'idBung' => $request->query->get('idBung')));
		}

		public function deleteBungAction(Request $request) {

			$em = $this->getDoctrine()->getManager();		
			$bungalow = $this->get('cva_gestion_membre')->GetBungById($request->query->get('id'));

			$nbDetails = $this->get('cva_gestion_membre')->GetNbDetailsByIdBung($request->query->get('id'));


			if($nbDetails>0)
			{
				$this->get('session')->getFlashBag()->add('warning', 'Ce bungalow n\'est pas vide !');
				return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
			}

			$em->remove($bungalow);
			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Bung supprimÃ©');
			return $this->redirect($this->generateUrl('cva_gestion_membre_config'));
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





		public function statsAction()
		{
		//Ventes Mois
			$ventesMois = $this->get('cva_gestion_membre')->VentesMoisCourant();
			$message = ($ventesMois<50? "C'est la loose Michel !":( $ventesMois<300? "Honnete." : ($ventesMois< 800? "Pas mal du tout !" : "Nickel, on va pouvoir combler le trou des 24 !")));

		//Stats par produits
			$prods = $this->get('cva_gestion_membre')->GetAllProduitDispo();
			$ventesProds = array();
			foreach($prods as $prod)
			{
				$ventes = count($this->get('cva_gestion_membre')->GetEtudiantByProduit($prod->getId()));
				$magot = $prod->getPrice()*$ventes;
				$ventesProds[]=array('prod' => $prod,'vendus' => $ventes,'magot' => $magot);
			}

		//Stats par années		
			$venteAnnee = array();
			$annees = array(1,2,3,4,5,'3CYCLE','Personnel','Autre');
			foreach($annees as &$annee)
			{
				$venteAnnee[$annee]=0;
			}

		//Stats par depart
			$venteDepart = array();
			$departs = array('PC','GEN','GCU','GI','GMC','GMD','GMPP','GE','IF','TC','BB','BIM','SGM');
			foreach($departs as &$depart)
			{
				$venteDepart[$depart]=0;
			}

			$adherents=$this->get('cva_gestion_membre')->GetActuelsAdherents();
			foreach($adherents as &$bizuth)
			{
				$venteAnnee[$bizuth->getAnnee()]++;
				if($bizuth->getDepartement()) {
					$venteDepart[$bizuth->getDepartement()]++;
				}
			}		
			

			return $this->render('CvaGestionMembreBundle::stats.html.twig',array('venteProds' => $ventesProds, 'venteAnnee' => $venteAnnee, 'venteDepart' => $venteDepart, 'ventesMois' => $ventesMois, 'message' => $message));
		}

	public function is_memberAction(Request $request)
	{
		$numEtu = $request->query->get('numEtu');
		$adh=$this->get('cva_gestion_membre')->IsCurrentAdherent($numEtu);

		$response = new JsonResponse();
		$response->setData(array(
			'member' => $adh==null ? false : true)
		);
		return $response;
	}

	public function assoCheckAction(Request $request)
	{
		return $this->render('CvaGestionMembreBundle::checkAsso.html.twig', array() );
	}



	}
