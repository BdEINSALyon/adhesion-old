<?php

namespace BdE\WeiBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BungalowRepository extends EntityRepository
{
    public function GetAllBungBySexe($sexe,$bung)
    {
    	$qb = $this->createQueryBuilder('b');
        $qb->where('b.nbPlaces > (SELECT COUNT(s) FROM BdEWeiBundle:DetailsWEI s WHERE s.bungalow = b.id)');
        if($bung<>NULL)
        	$qb->orWhere('b.id = :idBung')->setParameter('idBung', $bung->getId());
    	if($sexe!=-1)
    		$qb->andWhere('b.sexe = :sexe')->setParameter('sexe', $sexe);
        return $qb;
    }

    public function getAllNotFull(){
        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('b.etudiants','e');
        $qb->select("b");
        $qb->having("b.nbPlaces > COUNT(e.id)");
        $qb->groupBy("b.id");
        return $qb->getQuery()->getResult();
    }

    public function getAllNotFullByGender($sex){
        if($sex!=Bungalow::BOYS&&$sex!=Bungalow::GIRLS&&$sex!=Bungalow::NOT_DETERMINED){
            throw new \InvalidArgumentException("Sex should be a valid value from Bungalow::BOYS or Bungalow::GIRLS");
        }
        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('b.etudiants','e');
        $qb->select('b');
        $qb->where("b.sexe = ?1");
        $qb->groupBy("b.id");
        $qb->having("b.nbPlaces > COUNT(e.id)");
        $qb->setParameter(1, $sex);
        return $qb->getQuery()->getResult();
    }

    public function countNotFull(){
        return count($this->getAllNotFull());
    }

    public function countAmountOfPlaces(){
        $qb = $this->createQueryBuilder('b');
        $qb->select("SUM(b.nbPlaces)");
        return intval($qb->getQuery()->getSingleScalarResult());
    }

    public function countAmountOfAffectedEtudiant(){
        $qb = $this->createQueryBuilder("b");
        $qb->select("COUNT(e.id)");
        $qb->leftJoin("b.etudiants","e");
        return intval($qb->getQuery()->getSingleScalarResult());
    }
}