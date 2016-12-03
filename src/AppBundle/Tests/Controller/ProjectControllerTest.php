<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'project/list');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'project/view');
    }

}
