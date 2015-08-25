<?php

namespace BdE\WeiBundle\Entity;

use Cva\GestionMembreBundle\Entity\Etudiant;
use Doctrine\ORM\EntityRepository;

class BusRepository extends EntityRepository
{
    public function GetAllBusNonPleins($bus)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.nbPlaces > (SELECT COUNT(s) FROM BdEWeiBundle:DetailsWEI s WHERE s.bus = b.id)');
        if($bus<>NULL)
        	$qb->orWhere('b.id = :idBus')->setParameter('idBus', $bus->getId());
        return $qb;
    }

    /**
     * @param Etudiant $etudiant
     * @return Bus
     */
    public function getBusForEtudiant(Etudiant $etudiant){
        $qb = $this->createQueryBuilder('b');
        $qb->join('b.students','e','e.id = :e_id')->setParameter("e_id",$etudiant->getId());
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getAllNotFull()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('b.students','e');
        $qb->select("b");
        $qb->having("b.nbPlaces > COUNT(e.id)");
        $qb->groupBy("b.id");
        return $qb->getQuery()->getResult();
    }
}