<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 25/08/15
 * Time: 14:43
 */

namespace Cva\GestionMembreBundle\Service;


use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Produit;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Products
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * Products constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getProducts(){
        $products = array();
        $checker = $this->container->get("security.authorization_checker");
        $em = $this->container->get("doctrine.orm.entity_manager");
        $productsRepository = $em->getRepository("CvaGestionMembreBundle:Produit");
        if($checker->isGranted("ROLE_COWEI")){
            $seatsLeft = $this->container->get("bde.wei.registration_management")->getSeatsLeft();
            $hasWaitings = $em->getRepository("BdEWeiBundle:Waiting")->createQueryBuilder('waiting')->select('COUNT(waiting)')
                ->leftJoin("waiting.payment","payment")->where('payment.product IN (?1)')
                ->setParameter(1, $productsRepository->getWaitingProductFor($productsRepository->getCurrentWEI()))
                ->getQuery()->getSingleScalarResult();
            if($seatsLeft>0 && $hasWaitings == 0){
                $products[] = $productsRepository->getCurrentWEI();
            } else {
                $products[] = $productsRepository->getCurrentWEIWaiting();
            }
            $products[] = $productsRepository->getCurrentWEIPreInscription();
            $products[] = $productsRepository->getCurrentWEIPreWaiting();
            $products[] = $productsRepository->getCurrentWEIRemboursement();
        }
        $products = array_merge($products, $productsRepository->getCurrentVA());
        /** @var Produit $product */
        foreach($products as &$product){
            if(!$product->getActive()){
                unset($product);
            }
        }
        return $products;
    }

    public function getProductsFor(Etudiant $student){
        $products = $this->getProducts();
        $boughtProducts = $student->getProducts();
        /** @var Produit $product */
        foreach($products as &$product){
            foreach($boughtProducts as &$sproduct) {
                if($product == $sproduct || $product->getCanNotBeSoldWith()->contains($sproduct)){
                    unset($product);
                }
            }
        }
        return $products;
    }
}