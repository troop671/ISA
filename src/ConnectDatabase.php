<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final class ConnectDatabase
{
  public static function to(Environment $environment): PDO
  {
    return new PDO(
      sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $environment->databaseHost, $environment->databasePort, $environment->databaseName),
      $environment->databaseUser,
      $environment->databasePassword,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ],
    );
  }
}
