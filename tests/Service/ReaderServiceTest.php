<?php

namespace App\Tests\Service;

use App\Entity\Comic;
use App\Entity\Page;
use App\Factory\FactoryInterface;
use App\Provider\ComicProvider;
use App\Service\Archive\ArchiveInterface;
use App\Service\ReaderService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Selectable;
use PHPUnit\Framework\TestCase;

class ReaderServiceTest extends TestCase
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ComicProvider
     */
    private $provider;

    /**
     * @var ReaderService
     */
    private $service;

    public function setup()
    {
        $this->factory = $this->prophesize(FactoryInterface::class);
        $this->manager = $this->prophesize(EntityManagerInterface::class);
        $this->provider = $this->prophesize(ComicProvider::class);
        $this->service = new ReaderService(
            $this->factory->reveal(),
            $this->manager->reveal(),
            $this->provider->reveal()
        );
    }

    public function testRead()
    {
        $expected = [];
        // $comic = new Comic;
        // $this->provider->get(base64_encode('some_path.cbr'))->willReturn($comic);
        $archive = $this->prophesize(ArchiveInterface::class);
        $this->factory->build('some_path.cbr')->willReturn($archive->reveal());
        $archive->extract('some_path.cbr')->willReturn([]);
        $result = $this->service->read('some_path.cbr');

        $this->assertEquals($expected, $result);
    }
}
