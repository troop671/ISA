<?php

declare(strict_types=1);

namespace Troop671\Isa;

use Closure;
use PDO;
use Throwable;

final class RunTransaction
{
  public static function on(PDO $database, Closure $work): mixed
  {
    $database->beginTransaction();
    try {
      $result = $work();
      $database->commit();
      return $result;
    } catch (Throwable $throwable) {
      $database->rollBack();
      throw $throwable;
    }
  }
}
