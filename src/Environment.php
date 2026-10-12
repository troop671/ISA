<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class Environment
{
  public function __construct(
    public string $databaseHost,
    public int $databasePort,
    public string $databaseName,
    public string $databaseUser,
    public string $databasePassword,
    public string $smtpHost,
    public int $smtpPort,
    public SmtpEncryption $smtpEncryption,
    public string $smtpUser,
    public string $smtpPassword,
    public string $mailFromAddress,
    public string $mailFromName,
    public string $treasurerAddress,
    public int $sessionIdleSeconds,
  ) {
  }
}
