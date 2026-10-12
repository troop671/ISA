<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ListUsers
{
  public function __construct(private PDO $database)
  {
  }

  public function atLevel(string $level): array
  {
    $statement = $this->database->prepare('SELECT * FROM `users` WHERE `level` = :level ORDER BY `last` ASC, `first` ASC');
    $statement->execute(['level' => $level]);
    return array_map(User::fromRow(...), $statement->fetchAll());
  }

  public function firstGeneralMessage(): string
  {
    return (string) ($this->database->query('SELECT `gm` FROM `users` ORDER BY `gm` ASC LIMIT 1')->fetchColumn() ?: '');
  }
}
