<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 24/08/15
 * Time: 10:11
 */

namespace Cva\GestionMembreBundle\Form;


use Cva\GestionMembreBundle\Entity\Payment;
use Cva\GestionMembreBundle\Entity\Produit;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormInterface;

class MultiplePaymentsDataMapper implements DataMapperInterface
{

    /**
     * MultiplePaymentsDataMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * Maps properties of some data to a list of forms.
     *
     * @param mixed $data Structured data.
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     *
     * @throws Exception\UnexpectedTypeException if the type of the data parameter is not supported.
     */
    public function mapDataToForms($data, $forms)
    {

    }

    /**
     * Maps the data of a list of forms into the properties of some data.
     *
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     * @param mixed $data Structured data.
     *
     * @throws Exception\UnexpectedTypeException if the type of the data parameter is not supported.
     */
    public function mapFormsToData($forms, &$data)
    {

        $products = array();
        $method = 'NONE';
        foreach ($forms as $form) {
            if($form->getName() == 'products'){
                $products = $form->getData();
            } elseif($form->getName() == 'method'){
                $method = $form->getData();
            }
        }

        if($method == 'NONE'){
            $data = array();
            return;
        }

        $result = array();
        $billId = Payment::generateUUID();
        /** @var Produit $product */
        foreach($products as $product){
            $p = new Payment();
            $p->setMethod($method);
            $p->setProduct($product);
            $p->setDate(new \DateTime());
            $p->setBillId($billId);
            $result[] = $p;
        }
        $data = $result;
    }
}