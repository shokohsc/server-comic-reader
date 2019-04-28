<?php

namespace App\Factory;

use App\Exception\UnknownArchiveMimeTypeException;
use App\Service\Archive\ArchiveInterface;

interface FactoryInterface
{
  /**
   * @param  string           $path
   *
   * @return ArchiveInterface
   *
   * @throws UnknownArchiveMimeTypeException
   */
  public function build(string $path): ArchiveInterface;
}
