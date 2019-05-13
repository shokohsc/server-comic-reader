<?php

namespace App\Tests\Service\Archive;

use App\Service\Archive\RarArchive;
use PHPUnit\Framework\TestCase;

class RarArchiveTest extends TestCase
{
    /**
     * @var RarArchive
     */
    private $archive;

    public function setup()
    {
        $this->archive = new RarArchive();
    }

    protected function createArchive()
    {
    }
}
