<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class UpdateBalances
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(array $balancesById): void
  {
    RunTransaction::on($this->database, function () use ($balancesById): void {
      $statement = $this->database->prepare('UPDATE `users` SET `balance` = :balance, `last_update` = NOW() WHERE `id` = :id');
      array_map(static fn (int $id, string $balance): bool => $statement->execute(['balance' => $balance, 'id' => $id]), array_keys($balancesById), $balancesById);
    });
  }
}
