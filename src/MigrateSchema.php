<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class MigrateSchema
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(): array
  {
    return [
      $this->step('UsersEngineIsInnoDb', "SELECT `ENGINE` = 'InnoDB' FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'", 'ALTER TABLE `users` ENGINE = InnoDB'),
      $this->step('UsersCharacterSetIsUtf8mb4', "SELECT `TABLE_COLLATION` = 'utf8mb4_general_ci' FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'", 'ALTER TABLE `users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci'),
      $this->step('UsersUserIdIsUnique', "SELECT COUNT(*) > 0 FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND INDEX_NAME = 'user_id' AND NON_UNIQUE = 0", 'ALTER TABLE `users` ADD UNIQUE INDEX `user_id` (`user_id`)'),
      $this->step(
        'AccountUpdatesExists',
        "SELECT COUNT(*) > 0 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'account_updates'",
        'CREATE TABLE `account_updates` ('
        . ' `id` int NOT NULL AUTO_INCREMENT,'
        . ' `recorded_at` datetime NOT NULL,'
        . ' `recorded_by` int NOT NULL,'
        . " `action` enum('create','update') NOT NULL,"
        . ' `user_id` varchar(30) NOT NULL,'
        . ' `first` varchar(30) NOT NULL,'
        . ' `last` varchar(30) NOT NULL,'
        . ' `email` varchar(60) NOT NULL,'
        . ' `balance` varchar(30) NOT NULL,'
        . ' `notice` mediumtext NOT NULL,'
        . ' `locked` varchar(4) NOT NULL,'
        . ' PRIMARY KEY (`id`)'
        . ') ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci',
      ),
    ];
  }

  private function step(string $name, string $satisfied, string $apply): array
  {
    $already = (bool) $this->database->query($satisfied)->fetchColumn();
    if (!$already) {
      $this->database->exec($apply);
    }
    $now = (bool) $this->database->query($satisfied)->fetchColumn();
    return $now ? ['Step' => $name, 'Applied' => !$already] : throw new \RuntimeException('Migration step did not take effect: ' . $name);
  }
}
