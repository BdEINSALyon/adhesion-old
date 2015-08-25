<?php

namespace BdE\WeiBundle\Command;

use Cva\GestionMembreBundle\Entity\Etudiant;
use Cva\GestionMembreBundle\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeDataWEICommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('bde:wei:fake_data')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $em->beginTransaction();
        $output->writeln("Start loading old data ...");
        $s = $em->getRepository("CvaGestionMembreBundle:Etudiant")->createQueryBuilder('student')
            ->setMaxResults(450)->setFirstResult(500)->getQuery()->getResult();
        $product = $em->getRepository("CvaGestionMembreBundle:Produit")->getCurrentWEI();
        $date = new \DateTime();
        /** @var Etudiant $student */
        foreach ($s as $student) {
            $payment = new Payment();
            $payment->setBillId(Payment::generateUUID());
            $payment->setMethod("CHQ");
            $payment->setProduct($product);
            $payment->setDate($date);
            $payment->setStudent($student);
            $em->persist($payment);
        }
        $em->flush();
        $em->commit();

    }
}
