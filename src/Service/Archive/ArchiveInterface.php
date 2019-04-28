<?php

namespace App\Service\Archive;

use App\Service\Archive\ArchiveInterface;

interface ArchiveInterface
{
  /**
   * @param  string           $path
   *
   * @return array
   */
  public function extract(string $path): array;
}
