<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 16/08/15
 * Time: 14:25
 */

namespace Cva\GestionMembreBundle\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class EtudiantRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getOldMembersQuery(){
        $dql = "SELECT etu FROM CvaGestionMembreBundle:Etudiant etu ".
            "WHERE NOT EXISTS (SELECT p.id FROM CvaGestionMembreBundle:Payment p WHERE p.product IN (?1) AND p.student = etu)";
        $abstractQuery = $this->getEntityManager()->
        createQuery()->setDQL($dql)->setParameter(1, $this->getCurrentMembershipProducts());
        return $abstractQuery;
    }

    /**
     * @return Query
     */
    public function getMembersQuery(){
        $dql = "SELECT e FROM CvaGestionMembreBundle:Etudiant e".
            " LEFT JOIN e.payments p WHERE p.product IN (?1)";
        return $this->getEntityManager()->
            createQuery()->setDQL($dql)->setParameter(1, $this->getCurrentMembershipProducts());
    }

    /**
     * @return array
     */
    private function getCurrentMembershipProducts(){
        $em = $this->getEntityManager();
        $va = $em->getRepository("BdEMainBundle:Config")->get("cva.produitVA","1");
        return explode(",",$va);
    }

    /**
     * @param $search string Search for a student in this repository
     * @return Etudiant[]
     */
    public function search($search)
    {
        $search = '%'.$search.'%';
        $q = $this->createQueryBuilder("s")->where("s.firstName LIKE ?1")->orWhere("s.name LIKE ?1")
                ->orderBy("s.annee")->getQuery();
        $q->setParameter(1, $search);
        return $q->getResult();
    }
}