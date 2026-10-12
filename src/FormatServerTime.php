<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class FormatServerTime
{
  public static function of(int $timestamp): string
  {
    $time = getdate($timestamp);
    return sprintf('%s %s %d, %d at %d:%d:%d', $time['weekday'], $time['month'], $time['mday'], $time['year'], $time['hours'], $time['minutes'], $time['seconds']);
  }
}
