<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class LockUser
{
  public function __construct(private PDO $database)
  {
  }

  public function byId(int $id): void
  {
    $this->database->prepare("UPDATE `users` SET `locked` = 'yes' WHERE `id` = :value")->execute(['value' => $id]);
  }

  public function byUserId(string $userId): void
  {
    $this->database->prepare("UPDATE `users` SET `locked` = 'yes' WHERE `user_id` = :value")->execute(['value' => $userId]);
  }
}
