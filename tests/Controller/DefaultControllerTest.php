<?php

namespace App\Tests\Controller;

use App\Service\ReaderService;
use App\Service\ScanDirectoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testScan()
    {
        $client = static::createClient();
        $client->request('GET', '/scan');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRead()
    {
        $client = static::createClient();
        $client->request('GET', '/read/some_comic.cbr');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
