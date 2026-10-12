<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class ReadEnvironment
{
  public const array NAMES = [
    'ISA_DATABASE_HOST',
    'ISA_DATABASE_PORT',
    'ISA_DATABASE_NAME',
    'ISA_DATABASE_USER',
    'ISA_DATABASE_PASSWORD',
    'ISA_SMTP_HOST',
    'ISA_SMTP_PORT',
    'ISA_SMTP_ENCRYPTION',
    'ISA_SMTP_USER',
    'ISA_SMTP_PASSWORD',
    'ISA_MAIL_FROM_ADDRESS',
    'ISA_MAIL_FROM_NAME',
    'ISA_TREASURER_ADDRESS',
    'ISA_SESSION_IDLE_SECONDS',
  ];

  private const array INTEGERS = ['ISA_DATABASE_PORT', 'ISA_SMTP_PORT', 'ISA_SESSION_IDLE_SECONDS'];

  public static function fromProcess(): Environment
  {
    $values = array_combine(self::NAMES, array_map(static fn (string $name): string => (string) getenv($name), self::NAMES));
    $invalid = array_values(array_filter(
      self::NAMES,
      static fn (string $name): bool => $values[$name] === ''
        || (in_array($name, self::INTEGERS, true) && filter_var($values[$name], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false)
        || ($name === 'ISA_SMTP_ENCRYPTION' && SmtpEncryption::tryFrom($values[$name]) === null),
    ));
    if ($invalid !== []) {
      throw MissingEnvironment::named($invalid);
    }
    return new Environment(
      databaseHost: $values['ISA_DATABASE_HOST'],
      databasePort: (int) $values['ISA_DATABASE_PORT'],
      databaseName: $values['ISA_DATABASE_NAME'],
      databaseUser: $values['ISA_DATABASE_USER'],
      databasePassword: $values['ISA_DATABASE_PASSWORD'],
      smtpHost: $values['ISA_SMTP_HOST'],
      smtpPort: (int) $values['ISA_SMTP_PORT'],
      smtpEncryption: SmtpEncryption::from($values['ISA_SMTP_ENCRYPTION']),
      smtpUser: $values['ISA_SMTP_USER'],
      smtpPassword: $values['ISA_SMTP_PASSWORD'],
      mailFromAddress: $values['ISA_MAIL_FROM_ADDRESS'],
      mailFromName: $values['ISA_MAIL_FROM_NAME'],
      treasurerAddress: $values['ISA_TREASURER_ADDRESS'],
      sessionIdleSeconds: (int) $values['ISA_SESSION_IDLE_SECONDS'],
    );
  }
}
