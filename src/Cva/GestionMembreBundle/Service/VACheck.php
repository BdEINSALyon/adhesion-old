<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 05/09/15
 * Time: 19:22
 */

namespace Cva\GestionMembreBundle\Service;


use Cva\GestionMembreBundle\Entity\Etudiant;
use Doctrine\ORM\EntityManager;

class VACheck
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

    public function checkVA(Etudiant $student){
        $products = $this->em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentVAIds();
        $studentProducts = $student->getProducts();
        foreach ($studentProducts as $prod) {
            if(in_array($prod->getId(),$products)){
                return true;
            }
        }
        return false;
    }

}