<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDOException;

final class IsDuplicateKey
{
  public static function of(PDOException $exception): bool
  {
    return (int) ($exception->errorInfo[1] ?? 0) === 1062;
  }
}
