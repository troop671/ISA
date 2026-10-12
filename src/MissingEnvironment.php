<?php

declare(strict_types=1);

namespace Troop671\Isa;

use RuntimeException;

final class MissingEnvironment extends RuntimeException
{
  public static function named(array $names): self
  {
    return new self('Missing or invalid environment variables: ' . implode(', ', $names));
  }
}
