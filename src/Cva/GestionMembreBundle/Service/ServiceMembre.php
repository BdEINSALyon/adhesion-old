<?php

namespace Cva\GestionMembreBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cva\GestionMembreBundle\Form\EtudiantType;
use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Paiement;
use \DateTime;


class ServiceMembre {

	private $em;

	function __construct(\Doctrine\ORM\EntityManager $em) {
		
		 $this->em = $em;
	}

	
	public function GetAllEtudiant() {
	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		$etudiants = $repository->findAll();
		return $etudiants;
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
	
	public function GetEtudiantById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findOneById($id);
	}

	public function GetEtudiantByNumEtu($numEtu) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Etudiant');
		return $repository->findOneByNumEtudiant($numEtu);
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
	
	public function GetProduitById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Produit');
		return $repository->findOneById($id);
	}
	
	public function GetPaiementById($id) {	
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Paiement');
		return $repository->findOneById($id);
	}
	
	public function VentesMoisCourant()
	{

		$VAs=$this->GetProduitsLikeDesc('VA2013%');

		$repository = $this->em->getRepository('CvaGestionMembreBundle:Paiement');
		$today = getdate();
		$todayOk = $today['year'].'-0'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'].':'.$today['seconds'];
		$debutMois = $today['year'].'-0'.$today['mon'].'-01';

		$qb=$repository->createQueryBuilder('p');
		$query = $qb	->where('p.dateAchat BETWEEN :debut AND :auj')
			->setParameter('debut', $debutMois)
			->setParameter('auj', $todayOk)	
			->getQuery();
		
		$paiements = $query->getResult();

		$total=0;
		foreach($paiements as &$paiement)
		{	
			foreach($VAs as &$VA)
			{
				if(in_array($VA,$paiement->getProduits()->toArray()))
				{	
					$total++;
				}
			}		
		}

		return $total;
	}

	public function GetEtudiantByProduit($idProd)
	{
		//On recupere les paiements des Etudiant ayant achete ce produit
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Paiement');
		$query = $repository->createQueryBuilder('p') 
			->where(':idProd MEMBER OF p.produits')
			->setParameter('idProd', $idProd)
			->getQuery();
		$paiements = $query->getResult();
		
		//On recupere les etudiants associés
		$etudiant=array();

		foreach ($paiements as &$id) {
			$etud=$this->GetEtudiantById($id->getIdEtudiant());
			$etudiant[]=$etud;
		}
		return $etudiant;
	
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
	
	public function GetDetailsByIdEtudiant($idEtudiant)
	{
		$repository = $this->em->getRepository('CvaGestionMembreBundle:DetailsWEI');
		return $repository->findOneBy(array('idEtudiant' => $idEtudiant));
	}

	public function GetProduitsLikeDesc($desc)
	{
		$repository = $this->em->getRepository('CvaGestionMembreBundle:Produit');
		$query = $repository->createQueryBuilder('p') 
			->where('p.description LIKE :desc')
			->setParameter('desc', $desc)
			->getQuery();
		$produits = $query->getResult();
		
		return $produits;
	}
	
	public function GetProduitEtudiant($numEtu)
	{
		$query = $this->em->createQuery('SELECT Produit.description FROM Etudiant LEFT JOIN Paiement ON Etudiant.id=Paiement.etudiant_id LEFT JOIN paiement_produits ON Paiement.id=paiement_produits.paiement_id LEFT JOIN Produit ON paiement_produits.produit_id=Produit.id WHERE Etudiant.numEtudiant=:numEtu')->setParameter('numEtu' , $numEtu);

		$prodEtu = $query->getResult();

		return $prodEtu;
	}

	public function GetBizuthWEIAvecDetails()
	{
		$bizuths = $this->GetEtudiantByAnnee(1);
		$details=array();
		$repository = $this->em->getRepository('CvaGestionMembreBundle:DetailsWEI');

		$dateWEI = new DateTime('2013-09-20');
		
		foreach ($bizuths as &$biz)
		{
			//Test majeur/mineur
			$anniv = $biz->getBirthday();
			$inter = $anniv->diff($dateWEI);
			$age = $inter->format('%y');			
			
			//On récupère le bus et le bung du bizuth
			$bus="";
			$bungalow="";
			$allproducts=array();
			if($this->GetDetailsByIdEtudiant($biz->getId())<>null)
			{
				$bus= $repository->findOneByIdEtudiant($biz)->GetBus();
				$bungalow= $repository->findOneByIdEtudiant($biz)->GetBungalow();
			}
			
			//On récupère les produits achetés par le bizuth
			
			$paiements=$this->GetPaiementEtudiant($biz->getId());

			if($paiements<>null)
			{
				foreach ($paiements as &$paie)
				{
					$allproducts[]=$paie->getProduits();
				}
			}
			
			//On met tout dans le tableau
			$details[]=array("bizuth" => $biz,"bus" => $bus, "bung" => $bungalow, "prods" => $allproducts, "majeur" => ($age>=18?"Majeur":"Mineur"));
		}
		return $details;
	}
	
	
	
}
