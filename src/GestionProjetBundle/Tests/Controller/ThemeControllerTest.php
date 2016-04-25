<?php

namespace GestionProjetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ThemeControllerTest extends WebTestCase
{
    public function testAddtheme()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addTheme');
    }

    public function testUpdatetheme()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateTheme');
    }

    public function testListtheme()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listTheme');
    }

    public function testListonetheme()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listOneTheme');
    }

}
