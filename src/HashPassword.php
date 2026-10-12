<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class HashPassword
{
  public static function of(string $password): string
  {
    return password_hash($password, PASSWORD_ARGON2ID);
  }
}
