<?php

namespace BdE\WeiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testPreindex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/preregistred');
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registred');
    }

    public function testPrewaitingindex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/preregistred-waiting');
    }

    public function testIndexwaiting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registred-waiting');
    }

    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
    }

    public function testUnregister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/unregister');
    }

}
