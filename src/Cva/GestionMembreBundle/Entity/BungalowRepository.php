<?php

namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BungalowRepository extends EntityRepository
{
    public function GetAllBungBySexe($sexe,$bung)
    {
    	$qb = $this->createQueryBuilder('b');
        $qb->where('b.nbPlaces > (SELECT COUNT(s) FROM CvaGestionMembreBundle:DetailsWEI s WHERE s.bungalow = b.id)');
        if($bung<>NULL)
        	$qb->orWhere('b.id = :idBung')->setParameter('idBung', $bung->getId());
    	if($sexe!=-1)
    		$qb->andWhere('b.sexe = :sexe')->setParameter('sexe', $sexe);
        return $qb;
    }
}