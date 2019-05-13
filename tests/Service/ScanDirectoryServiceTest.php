<?php

namespace App\Tests\Service;

use App\Service\ScanDirectoryService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ScanDirectoryServiceTest extends TestCase
{
    /**
     * @var ScanDirectoryService
     */
    private $service;

    public function setup()
    {
        $this->service = new ScanDirectoryService('/tmp');
    }
}
