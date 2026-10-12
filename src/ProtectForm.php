<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class ProtectForm
{
  public static function token(): string
  {
    $_SESSION['FormToken'] ??= bin2hex(random_bytes(32));
    return $_SESSION['FormToken'];
  }

  public static function accepts(array $form): bool
  {
    return is_string($form['form_token'] ?? null) && hash_equals(self::token(), $form['form_token']);
  }
}
