<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 27/08/15
 * Time: 14:15
 */

namespace Cva\GestionMembreBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Statistical service.
 * This service provides statistics on selling and memberships on this bundle.
 * @package Cva\GestionMembreBundle\Service
 */
class StatsService
{
    /**
     * @var EntityManager
     */
    private $em;


    /**
     * StatsService constructor.
     * @param EntityManager $em Used to access data in this package
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Count numbers of sales and amount of products sold for each active product.
     * @return string[][] An array which contains on each sub array the "product", the "amount" and the "money"
     */
    public function getSellsByActiveProduct(){
        $qb = $this->em->createQueryBuilder()->select("p.name as product")->addSelect("count(payment) as amount")
            ->addSelect("(p.price * count(payment)) as money")
            ->from("CvaGestionMembreBundle:Produit","p")->where("p.active = true")
            ->leftJoin("p.payments","payment")->groupBy("p.name")->orderBy("p.id");
        return $qb->getQuery()->getResult();
    }

    /**
     * Count numbers of members by years of study.
     * @return string[] An array which contains numbers indexed by years
     */
    public function getMembersByYear(){
        $qb = $this->em->createQueryBuilder()->select("e.annee as year")->addSelect("count(e) as number")
            ->from("CvaGestionMembreBundle:Etudiant","e")->where("payment.product IN (?1)")
            ->leftJoin("e.payments","payment")->groupBy("e.annee")->orderBy("e.annee");
        $qb->setParameter(1, $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVA());
        return $this->remapValuesAsKeys($qb->getQuery()->getResult(),"year","number");
    }

    /**
     * Count numbers of members by departement of study.
     * @return string[] An array which contains numbers indexed by department
     */
    public function getMembersByDepartment(){
        $qb = $this->em->createQueryBuilder()->select("e.departement as department")->addSelect("count(e) as number")
            ->from("CvaGestionMembreBundle:Etudiant","e")->where("payment.product IN (?1)")
            ->leftJoin("e.payments","payment")->groupBy("e.departement")->orderBy("e.departement");
        $qb->setParameter(1, $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVA());
        return $this->remapValuesAsKeys($qb->getQuery()->getResult(),"department","number");
    }

    private function remapValuesAsKeys($array, $keyKey, $valueKey){
        $return = [];
        foreach ($array as $entry) {
            $return[$entry[$keyKey]] = $entry[$valueKey];
        }
        return $return;

    }
}