<?php
/**
 * Created by PhpStorm.
 * User: Philippe Vienne
 * Date: 09/08/2015
 * Time: 13:20
 */

namespace BdE\WeiBundle\Tests;


use BdE\WeiBundle\Entity\Config;
use BdE\WeiBundle\Entity\ConfigRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConfigRepositoryTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var ConfigRepository
     */
    private $repo;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
        $this->repo = $this->em->getRepository("BdEWeiBundle:Config");
    }

    public function testReset(){
        $randomConfigElement = new Config();
        $randomConfigElement->setValue("AnValueWhichNotExists");
        $randomConfigElement->setName("ThisNameIsUsedForTesting!");
        $this->em->persist($randomConfigElement);
        $this->em->commit();
//        $this->em->beginTransaction();
//        $this->repo->resetConfiguration();
//        $q=$this->repo->createQueryBuilder('c')->where("c.name = ?1")->setParameter(1,$randomConfigElement->getName())->getQuery();
//        $q->useResultCache(false);
//        $r = $q->getArrayResult();
//        $this->assertEmpty($r);
    }
}
