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

  /**
   * @param  string           $path
   *
   * @return array
   */
  public function preview(string $path): array;
}
