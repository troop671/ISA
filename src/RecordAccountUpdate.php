<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class RecordAccountUpdate
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $recordedBy, string $action, AccountForm $form): void
  {
    $this->database->prepare(
      'INSERT INTO `account_updates` (`recorded_at`, `recorded_by`, `action`, `user_id`, `first`, `last`, `email`, `balance`, `notice`, `locked`)'
      . ' VALUES (NOW(), :recorded_by, :action, :user_id, :first, :last, :email, :balance, :notice, :locked)',
    )->execute([
      'recorded_by' => $recordedBy,
      'action' => $action,
      'user_id' => $form->userId,
      'first' => $form->first,
      'last' => $form->last,
      'email' => $form->email,
      'balance' => $form->balance,
      'notice' => $form->notice,
      'locked' => $form->locked,
    ]);
  }
}
