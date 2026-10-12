<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class ClassifyEmail
{
  private const string PATTERN = '#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si';

  public static function of(string $email): EmailVerdict
  {
    return match (true) {
      preg_match(self::PATTERN, $email) !== 1 => EmailVerdict::Invalid,
      preg_match('/bcc:|cc:/', $email) === 1 => EmailVerdict::Spam,
      default => EmailVerdict::Valid,
    };
  }
}
