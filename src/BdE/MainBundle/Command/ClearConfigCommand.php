<?php

namespace BdE\MainBundle\Command;

use BdE\MainBundle\Entity\Config;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class ClearConfigCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('bde:clear_config')
            ->setDescription('Reset all config for this application');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $em->beginTransaction();
        $output->writeln("Clean the config ...");
        $em->createQueryBuilder()->delete()->from('BdEMainBundle:Config','c')->getQuery()->execute();
        $output->writeln("Config cleaned, now load the new config ...");
        $kernel = $this->getContainer()->get('kernel');
        $path = $kernel->locateResource("@BdEMainBundle/Resources/config/default_config.yml");
        $defaultConfig = Yaml::parse(file_get_contents($path));
        foreach ($defaultConfig as $name => $value) {
            $config = new Config();
            $config->setName($name);
            $config->setValue($value);
            $em->persist($config);
            $output->writeln("Create ".$name." with value ".$value);
        }
        $em->flush();
        $em->commit();
        $output->writeln("Done", OutputInterface::OUTPUT_NORMAL);
    }
}
