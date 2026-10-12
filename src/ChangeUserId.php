<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;
use PDOException;

final readonly class ChangeUserId
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $id, string $userId): bool
  {
    try {
      $this->database->prepare('UPDATE `users` SET `user_id` = :value WHERE `id` = :id')->execute(['value' => $userId, 'id' => $id]);
      return true;
    } catch (PDOException $exception) {
      return IsDuplicateKey::of($exception) ? false : throw $exception;
    }
  }
}
