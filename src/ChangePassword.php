<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ChangePassword
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $id, string $password): User
  {
    $this->database->prepare('UPDATE `users` SET `password_hash` = :hash WHERE `id` = :id')->execute(['hash' => HashPassword::of($password), 'id' => $id]);
    return (new FindUser($this->database))->byId($id) ?? throw new \RuntimeException('User vanished after password change: ' . $id);
  }
}
