<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class StartSession
{
  public static function start(): void
  {
    session_start([
      'cookie_httponly' => true,
      'cookie_samesite' => 'Lax',
      'use_strict_mode' => true,
    ]);
  }

  public static function signIn(User $user): void
  {
    session_regenerate_id(true);
    $_SESSION['UserId'] = $user->id;
    $_SESSION['Credential'] = $user->credential();
    $_SESSION['LoginTime'] = time();
    $_SESSION['LastActive'] = time();
  }

  public static function refreshCredential(User $user): void
  {
    $_SESSION['Credential'] = $user->credential();
  }

  public static function end(): void
  {
    $_SESSION = [];
    session_destroy();
  }
}
