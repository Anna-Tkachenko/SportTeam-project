<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 14:50
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertCount(1,  $crawler->filter('input#inputPassword'));
        self::assertCount(1,  $crawler->filter('input#inputUsername'));
        self::assertCount(1,  $crawler->filter('button#inputSubmit'));
    }

    public function testRegistration()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');

        self::assertEquals(200, $client->getResponse()->getStatusCode());

    }
}