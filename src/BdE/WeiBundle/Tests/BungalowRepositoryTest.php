<?php
/**
 * Created by IntelliJ IDEA.
 * User: Philippe Vienne
 * Date: 08/08/2015
 * Time: 16:03
 */

namespace BdE\WeiBundle\Tests;


use BdE\WeiBundle\Entity\Bungalow;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BungalowRepositoryTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetAllNotFull(){
        $this->assertNotNull($this->em->getRepository("BdEWeiBundle:Bungalow")->getAllNotFull());
    }
}
