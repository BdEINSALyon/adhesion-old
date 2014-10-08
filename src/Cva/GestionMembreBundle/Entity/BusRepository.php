<?php

namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BusRepository extends EntityRepository
{
    public function GetAllBusNonPleins($bus)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.nbPlaces > (SELECT COUNT(s) FROM CvaGestionMembreBundle:DetailsWEI s WHERE s.bus = b.id)');
        if($bus<>NULL)
        	$qb->orWhere('b.id = :idBus')->setParameter('idBus', $bus->getId());
        return $qb;
    }    
}