<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        self::assertCount(1, $crawler->filter('input#inputPassword'));
        self::assertCount(1, $crawler->filter('input#inputUsername'));
        self::assertCount(1, $crawler->filter('button#inputSubmit'));
    }

    public function testRegistration()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
