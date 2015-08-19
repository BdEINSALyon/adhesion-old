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
            "WHERE etu NOT IN (".$this->getMembersQuery()->getDQL().")";
        return $this->getEntityManager()->
            createQuery()->setDQL($dql)->setParameter(1, $this->getCurrentMembershipProducts());
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
}