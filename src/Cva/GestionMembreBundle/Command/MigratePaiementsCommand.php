<?php

namespace Cva\GestionMembreBundle\Command;

use Cva\GestionMembreBundle\Entity\Paiement;
use Cva\GestionMembreBundle\Entity\Payment;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigratePaiementsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('cva:migrate:1')
            ->setDescription('Migrate Paiement data');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $methodsMapping = array('Cheque' => 'CHQ', 'CB' => 'CB', 'Especes' => 'ESP');
        /** @var EntityManager $em */
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $em->beginTransaction();
        $output->writeln("Start loading old data ...");
        /** @var Paiement[] $results */
        $results = $em->createQuery("SELECT p FROM CvaGestionMembreBundle:Paiement as p")->getResult();
        $output->writeln("Create new entities ...");
        foreach($results as $paiement){
            $billId = $this->getGUID();
            foreach($paiement->getProduits() as $produit){
                $payment = new Payment();
                $payment->setBillId($billId);
                $payment->setProduct($produit);
                $payment->setMethod($methodsMapping[$paiement->getMoyenPaiement()]);
                $payment->setStudent($paiement->getIdEtudiant());
                $payment->setDate($paiement->getDateAchat());
                $em->persist($payment);
            }
        }
        $output->writeln("Start injecting in new table ...");
        $em->flush();
        $em->commit();
    }

    private function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }
}
