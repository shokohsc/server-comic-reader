<?php

namespace App\Tests\Factory;

use App\Exception\UnknownArchiveMimeTypeException;
use App\Factory\ArchiveFactory;
use App\Service\Archive\ArchiveInterface;
use App\Service\Archive\RarArchive;
use App\Service\Archive\ZipArchive;
use Symfony\Component\Mime\MimeTypes;
use PHPUnit\Framework\TestCase;

class ArchiveFactoryTest extends TestCase
{
    /**
     * @var MimeTypes
     */
    private $mimetypes;

    /**
     * @var ArchiveFactory
     */
    private $factory;

    public function setup()
    {
        $this->mimetypes = $this->prophesize(MimeTypes::class);
        $this->factory = new ArchiveFactory($this->mimetypes->reveal());
    }

    protected function createArchive()
    {
    }
}
