<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ChangeQuestion
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $id, string $value): void
  {
    $this->database->prepare('UPDATE `users` SET `question` = :value WHERE `id` = :id')->execute(['value' => $value, 'id' => $id]);
  }
}
