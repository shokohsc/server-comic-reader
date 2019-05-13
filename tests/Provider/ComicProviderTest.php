<?php

namespace App\Tests\Provider;

use App\Entity\Comic;
use App\Provider\ComicProvider;
use App\Repository\ComicRepository;
use PHPUnit\Framework\TestCase;

class ComicProviderTest extends TestCase
{
    /**
     * @var ComicProvider
     */
    private $provider;

    /**
     * @var ComicRepository
     */
    private $repository;

    public function setup()
    {
        $this->repository = $this->prophesize(ComicRepository::class);
        $this->provider = new ComicProvider($this->repository->reveal());
    }

    public function testGet()
    {
        $expected = new Comic();
        $this->repository->findOneBy(['hash' => 'some_hash'])->willReturn($expected);
        $result = $this->provider->get('some_hash');

        $this->assertEquals($expected, $result);
    }
}
