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
    }
}