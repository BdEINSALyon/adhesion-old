<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 26/08/15
 * Time: 11:42
 */

namespace Cva\GestionMembreBundle\Validator\Constraints;


use Cva\GestionMembreBundle\Entity\Produit;
use Cva\GestionMembreBundle\Service\Products;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\CoreBundle\Tests\Entity\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProductSellValidator extends ConstraintValidator
{

    /**
     * @var Products
     */
    private $products;


    /**
     * ProductSellValidator constructor.
     * @param Products $products
     */
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param ArrayCollection $value
     * @param ProductSell|Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var Produit[][] $violations */
        $violations = [];
        $alreadyChecked = new ArrayCollection();
        /** @var Produit $product */
        foreach ($value as $product) {
            $alreadyChecked->add($product);
            foreach($product->getCanNotBeSoldWith() as $deniedProduct){
                if(!$alreadyChecked->contains($deniedProduct) && $value->contains($deniedProduct)){
                    $violations[] = array($product, $deniedProduct);
                }
            }
        }
        foreach($violations as $violation){
            $this->context->addViolation($constraint->message,array(
                'p1'=>$violation[0]->getName(),
                'p2'=>$violation[1]->getName()
            ));
        }

    }
}