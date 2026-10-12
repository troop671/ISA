<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class FindUser
{
  public function __construct(private PDO $database)
  {
  }

  public function byId(int $id): ?User
  {
    return $this->one('SELECT * FROM `users` WHERE `id` = :value', $id);
  }

  public function byUserId(string $userId): ?User
  {
    return $this->one('SELECT * FROM `users` WHERE `user_id` = :value', $userId);
  }

  private function one(string $sql, int|string $value): ?User
  {
    $statement = $this->database->prepare($sql);
    $statement->execute(['value' => $value]);
    $row = $statement->fetch();
    return is_array($row) ? User::fromRow($row) : null;
  }
}
