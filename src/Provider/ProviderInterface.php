<?php

namespace App\Provider;

use App\Entity\Comic;

interface ProviderInterface
{
  /**
   * @param  string           $hash
   *
   * @return Comic|null
   */
  public function get(string $hash);
}
