<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class CountFailedAttempts
{
  public static function current(): int
  {
    return (int) ($_SESSION['FailedAttempts'] ?? 0);
  }

  public static function normalized(): int
  {
    return in_array(self::current(), [1, 2, 3], true) ? self::current() : 0;
  }

  public static function record(): int
  {
    $_SESSION['FailedAttempts'] = self::normalized() + 1;
    return $_SESSION['FailedAttempts'];
  }
}
