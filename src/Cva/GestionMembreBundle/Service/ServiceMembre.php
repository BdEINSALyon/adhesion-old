<?php

namespace Cva\GestionMembreBundle\Service;

use BdE\WeiBundle\Entity\Bus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Paiement;
use \DateTime;


class ServiceMembre {

	private $em;
	private $fileConfigWEI = "../app/config/configWEI.txt";
	private $fileConfigGeneral = "../app/config/configGeneral.txt";


	function __construct(\Doctrine\ORM\EntityManager $em) {
		
		$this->em = $em;
	}

	
	public function GetAllEtudiant() {

		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		$etudiants = $repository->findAll();
		return $etudiants;
	}

	public function GetAllBus() {

		$repository = $this->em->getRepository('BdEWeiBundle:Bus');

		$query = $repository->createQueryBuilder('b')->orderBy('b.nom', 'ASC')->getQuery();
		
		return $query->getResult();
	}

	public function GetAllBusAvecPlacesPrises() {

		$allBus = $this->GetAllBus();
		$result = array();

		foreach ($allBus as &$b)  {
			$query = $this->em->createQuery(
				'SELECT COUNT(d)
				FROM BdEWeiBundle:DetailsWEI d
				WHERE d.bus = (?1) ')
			->setParameter(1 , $b);
			$totalCourant = $query->getSingleScalarResult();
			$result[] = array($b,$totalCourant);
		}
		return $result;
	}

	public function GetAllBungAvecPlacesPrises() {

		$allBung = $this->GetAllBung();
		$result = array();

		foreach ($allBung as &$b)  {
			$query = $this->em->createQuery(
				'SELECT COUNT(d)
				FROM BdEWeiBundle:DetailsWEI d
				WHERE d.bungalow = (?1) ')
			->setParameter(1 , $b);
			$totalCourant = $query->getSingleScalarResult();
			$result[] = array($b,$totalCourant);
		}
		return $result;
	}

	public function GetAllBung() {

		$repository = $this->em->getRepository('BdEWeiBundle:Bungalow');

		$query = $repository->createQueryBuilder('b')->orderBy('b.nom', 'ASC')->getQuery();
		
		return $query->getResult();

	}

	public function GetAllBungBySexe($idEtu) {

		$repository = $this->em->getRepository('BdEWeiBundle:Bungalow');

		$etudiant = $this->GetEtudiantById($idEtu);

		if($etudiant->getCivilite()=="M")
		{
			$sexe="M";
		}
		else
		{
			$sexe="F";
		}

		$bungalow = $repository->findBySexe($sexe);
		return $bungalow;
	}

	public function GetAllProduit() {

		$repository = $this->em->getRepository('CvaGestionMembreBundle:Produit');

		$query = $repository->createQueryBuilder('p')->orderBy('p.description', 'ASC')->getQuery();
		
		return $query->getResult();
	}

	public function GetAllProduitDispo() {

		$repository = $this->em->getRepository('CvaGestionMembreBundle:Produit');

		$query = $repository->createQueryBuilder('p')
		->where('p.disponibilite=:disponibilite')
		->setParameter('disponibilite', 'OUI')
		->getQuery();
		$produits = $query->getResult();

		return $produits;
	}
	
	public function GetPaiementEtudiant($idEtudiant) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Paiement');	
		return $repository->findBy(array('idEtudiant' => $idEtudiant));
	}

    /**
     * @param $id mixed
     * @return Etudiant
     */
	public function GetEtudiantById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findOneById($id);
	}

	public function GetEtudiantByNumEtu($numEtu) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findOneByNumEtudiant($numEtu);
	}

	public function GetEtudiantByCivilite($civilite) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findByCivilite($civilite);
	}

	public function GetRemplacantsWEI($civilite) //TODO Changer la méthode de récupération
	{
		$bungMixtes="";
		$produitInscritWEI="";
		if(file_exists($this->fileConfigWEI))
		{
			$json = json_decode(file_get_contents($this->fileConfigWEI),true);
			$bungMixtes=$json["bungMixtes"];
			$produitInscritWEI=$json["produitInscriptionWEI"];
		}

		$stringQuery = 'SELECT e
				FROM CvaGestionMembreBundle:Etudiant e
				WHERE e IN (
					SELECT etu
					FROM  CvaGestionMembreBundle:Paiement p
					LEFT JOIN p.produits pr
					LEFT JOIN p.idEtudiant etu';
		if($bungMixtes=="OUI")
		{
			$stringQuery.= ' WHERE pr.id IN (?1) ) ORDER BY e.name';
			$query = $this->em->createQuery($stringQuery)->setParameter(1 , $produitInscritWEI);
		}
		else
		{
			$stringQuery.= ' WHERE pr.id IN (?1) AND etu.civilite = (?2)) ORDER BY e.name';
			$query = $this->em->createQuery($stringQuery)
				->setParameter(1 , $produitInscritWEI)
				->setParameter(2 , $civilite);
		}

		$etudiants = $query->getResult();
		return $etudiants;
	}

	public function GetEtudiantByAnnee($annee) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findByAnnee($annee);
	}

	public function GetEtudiantByDepartement($depart) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findByDepartement($depart);
	}

	public function GetUserById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:User');
		return $repository->findOneById($id);
	}

	/**
	 * @param $id
	 * @return \BdE\WeiBundle\Entity\Bus
	 */
	public function GetBusById($id) {	
		$repository = $this->em->getRepository('BdEWeiBundle:Bus');
		return $repository->findOneById($id);
	}

	public function GetBungById($id) {	
		$repository = $this->em->getRepository('BdEWeiBundle:Bungalow');
		return $repository->findOneById($id);
	}
	
	public function GetProduitById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Produit');
		return $repository->findOneById($id);
	}
	
	public function GetPaiementById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Paiement');
		return $repository->findOneById($id);
	}

	public function GetProduitsVA()
	{
		$produitsVA=array();
		if(file_exists($this->fileConfigGeneral))
		{
			$json = json_decode(file_get_contents($this->fileConfigGeneral),true);
			$produitsVA=$json["produitsVA"];
		}
		return $produitsVA;

	}
	
	public function VentesMoisCourant()
	{

		$produitsVA=$this->GetProduitsVA();
		$today = getdate();
		$todayOk = $today['year'].'-0'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'].':'.$today['seconds'];
		$debutMois = $today['year'].'-0'.$today['mon'].'-01';

		$query = $this->em->createQuery(
				'SELECT COUNT(e)
				FROM CvaGestionMembreBundle:Etudiant e
				WHERE e IN (
					SELECT etu
					FROM  CvaGestionMembreBundle:Paiement p
					LEFT JOIN p.produits pr
					LEFT JOIN p.idEtudiant etu
					WHERE p.dateAchat BETWEEN (?1) AND (?2) 
					AND pr.id IN (?3) )')
		->setParameter(1 , $debutMois)
		->setParameter(2 , $todayOk)
		->setParameter(3 , $produitsVA);

		$nbVentes = $query->getSingleScalarResult();

		return $nbVentes;
	}

	public function GetEtudiantByProduit($idProd)
	{
		$query = $this->em->createQuery(
				'SELECT e
				FROM CvaGestionMembreBundle:Etudiant e
				WHERE e IN (
					SELECT etu
					FROM  CvaGestionMembreBundle:Paiement p
					LEFT JOIN p.produits pr
					LEFT JOIN p.idEtudiant etu
					WHERE pr.id IN (?1) )')
		->setParameter(1 , $idProd);

		$etudiants = $query->getResult();
		return $etudiants;
	}

	public function EtudiantAlreadyGotProduct($idEtudiant, $produit)
	{
		$paiements = $this->GetPaiementEtudiant($idEtudiant);
		foreach( $paiements as &$paie )
		{
			if((in_array($produit, $paie->getProduits()->toArray())))
			{
				return true;
			}
		}
		return false;
	}
	
	public function GetAllDetails()
	{
		$repository = $this->em->getRepository('BdEWeiBundle:DetailsWEI');
		$details = $repository->findAll();
		return $details;
	}
	
	public function GetDetailsByIdEtudiant($idEtudiant)
	{
		$repository = $this->em->getRepository('BdEWeiBundle:DetailsWEI');
		return $repository->findOneBy(array('idEtudiant' => $idEtudiant));
	}

	public function GetNbDetailsByIdBus($idBus)
	{
		$query = $this->em->createQuery(
			'SELECT COUNT(d.id) 
			FROM BdEWeiBundle:DetailsWEI d
			WHERE d.bus=:idBus')
		->setParameter('idBus',$idBus);
		$nb = $query->getSingleScalarResult();

		return $nb;
	}

	public function GetNbDetailsByIdBung($idBung)
	{
		$query = $this->em->createQuery(
			'SELECT COUNT(d.id) 
			FROM BdEWeiBundle:DetailsWEI d
			WHERE d.bungalow=:idBung')
		->setParameter('idBung',$idBung);
		$nb = $query->getSingleScalarResult();

		return $nb;
	}

	public function GetMaxListeAttente()
	{
		$query = $this->em->createQuery(
			'SELECT MAX(d.placeListeAttente) 
			FROM BdEWeiBundle:DetailsWEI d');
		$max = $query->getSingleResult();

		return $max;
	}
	
	public function GetProduitEtudiant($numEtu)
	{
		$query = $this->em->createQuery(
			'SELECT Produit.description 
			FROM Etudiant 
			LEFT JOIN Paiement ON Etudiant.id=Paiement.etudiant_id 
			LEFT JOIN paiement_produits ON Paiement.id=paiement_produits.paiement_id 
			LEFT JOIN Produit ON paiement_produits.produit_id=Produit.id 
			WHERE Etudiant.numEtudiant=:numEtu')
		->setParameter('numEtu' , $numEtu);

		$prodEtu = $query->getResult();

		return $prodEtu;
	}

	public function GetActuelsAdherents()
	{
		$produitsVA=$this->GetProduitsVA();

		$query = $this->em->createQuery(
				'SELECT e
				FROM CvaGestionMembreBundle:Etudiant e, CvaGestionMembreBundle:Produit prod
				WHERE e IN (
					SELECT etu
					FROM  CvaGestionMembreBundle:Paiement p
					LEFT JOIN p.produits pr
					LEFT JOIN p.idEtudiant etu
					WHERE pr.id IN (?1) )')
		->setParameter(1 , $produitsVA);

		$etudiant = $query->getResult();

		return $etudiant;
	}

	public function IsCurrentAdherent($numEtu)
	{
		$produitsVA=$this->GetProduitsVA();

		$query = $this->em->createQuery(
				'SELECT e
				FROM CvaGestionMembreBundle:Etudiant e, CvaGestionMembreBundle:Produit prod
				WHERE e IN (
					SELECT etu
					FROM  CvaGestionMembreBundle:Paiement p
					LEFT JOIN p.produits pr
					LEFT JOIN p.idEtudiant etu
					WHERE pr.id IN (?1) AND etu.numEtudiant = (?2) )')
		->setParameter(1 , $produitsVA)
		->setParameter(2 , $numEtu);

		$etudiant = $query->getResult();

		return $etudiant;
	}

	public function GetAnciensAdherents()
	{
		$produitsVA=$this->GetProduitsVA();
		
		$query = $this->em->createQuery(
			'SELECT e
			FROM CvaGestionMembreBundle:Etudiant e
			WHERE e NOT IN (
				SELECT etu
				FROM  CvaGestionMembreBundle:Paiement p
				LEFT JOIN p.produits pr
				LEFT JOIN p.idEtudiant etu
				WHERE pr.id IN (?1) )')
		->setParameter(1 , $produitsVA);

		$etudiant = $query->getResult();

		return $etudiant;

	}

	public function EnvoiMailAdherent($adherent)
	{
		$message = \Swift_Message::newInstance()
		->setSubject('Adhésion Vie Associative')
		->setFrom(array('va@va.com'=> 'Appli VA'))
		->setTo($adherent->getMail())
		->setBody($this->renderView(
                'Cva:GestionMembreBundle:mail.html',
                array('name' => $adherent->getName())
            ));
		$this->get('mailer')->send($message);
	}

	public function GetBizuthWEIAvecDetails($idProduit)
	{
		$bizuths = $this->GetEtudiantByProduit($idProduit);
		$details=array();
		$repository = $this->em->getRepository('BdEWeiBundle:DetailsWEI');

		//Tout le monde était mineur, full images -18
		$stringDateWEI="2005-01-01";

		if(file_exists($this->fileConfigWEI))
		{
			$json = json_decode(file_get_contents($this->fileConfigWEI),true);
			$stringDateWEI=$json["dateWEI"];

		}

		$dateWEI = new DateTime($stringDateWEI);
		
		foreach ($bizuths as &$biz)
		{
			//Test majeur/mineur
			$anniv = $biz->getBirthday();
			$inter = $anniv->diff($dateWEI);
			$age = $inter->format('%y');			
			
			//On récupère le bus et le bung du bizuth
			$bus="";
			$bungalow="";
			$placeListeAttente="";
			$allproducts=array();
			if($this->GetDetailsByIdEtudiant($biz->getId())<>null)
			{
				if($repository->findOneByIdEtudiant($biz)->GetBus()!=NULL)
					$bus= $repository->findOneByIdEtudiant($biz)->GetBus()->GetNom();
				if($repository->findOneByIdEtudiant($biz)->GetBungalow()!=NULL)
					$bungalow= $repository->findOneByIdEtudiant($biz)->GetBungalow()->GetNom();
				$placeListeAttente= $repository->findOneByIdEtudiant($biz)->GetPlaceListeAttente();
			}
			
			//On récupère les produits achetés par le bizuth
			
			$paiements=$this->GetPaiementEtudiant($biz->getId());

			if($paiements<>null)
			{
				foreach ($paiements as &$paie)
				{
					$allproducts[]=array($paie->getProduits(),$paie->getDateAchat(),$paie->getMoyenPaiement());
				}
			}
			
			//On met tout dans le tableau
			$details[]=array("bizuth" => $biz,"bus" => $bus, "bung" => $bungalow, "placeListeAttente" => $placeListeAttente, "prods" => $allproducts, "majeur" => ($age>=18?"Majeur":"Mineur"));
		}
		return $details;
	}
	
	
	
}
