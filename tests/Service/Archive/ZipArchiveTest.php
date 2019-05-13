<?php

namespace App\Tests\Service\Archive;

use App\Service\Archive\ZipArchive;
use PHPUnit\Framework\TestCase;

class ZipArchiveTest extends TestCase
{
    /**
     * @var ZipArchive
     */
    private $archive;

    public function setup()
    {
        $this->archive = new ZipArchive();
    }

    protected function createArchive()
    {
    }
}
