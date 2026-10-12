<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class SendGeneralMessage
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(string $message): void
  {
    $this->database->prepare("UPDATE `users` SET `gm` = :gm WHERE `user_id` != ''")->execute(['gm' => $message]);
  }
}
