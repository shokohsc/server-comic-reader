<?php

namespace App\Service\Archive;

interface ArchiveInterface
{
  /**
   * @param  string           $path
   *
   * @return array
   */
  public function extract(string $path): array;
}
