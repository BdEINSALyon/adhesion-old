<?php

namespace BdE\WeiBundle\Command;

use BdE\WeiBundle\Entity\DetailsWEI;
use BdE\WeiBundle\Entity\Waiting;
use Cva\GestionMembreBundle\Entity\Paiement;
use Cva\GestionMembreBundle\Entity\Payment;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateWEIDataCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('bde:migrate:wei')
            ->setDescription('Migrate WEI data');
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
        /** @var DetailsWEI[] $results */
        $results = $em->getRepository("BdEWeiBundle:DetailsWEI")->findAll();
        $output->writeln("Create new entities ...");
        foreach($results as $detail){
            if($detail->getPlaceListeAttente()!=null){
                $waiting = new Waiting();
                $waiting->setRank($detail->getPlaceListeAttente());
                $waiting->setStudent($detail->getIdEtudiant());
                $em->persist($waiting);
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
