<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class DeleteAccount
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $id): void
  {
    $this->database->prepare('DELETE FROM `users` WHERE `id` = :id')->execute(['id' => $id]);
  }
}
