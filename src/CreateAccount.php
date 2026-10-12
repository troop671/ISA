<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;
use PDOException;

final readonly class CreateAccount
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $recordedBy, AccountForm $form): bool
  {
    try {
      return RunTransaction::on($this->database, function () use ($recordedBy, $form): bool {
        $this->database->prepare(
          'INSERT INTO `users` (`first`, `last`, `user_id`, `password_hash`, `email`, `balance`, `last_update`, `question`, `answer`, `notice`, `gm`, `level`, `locked`)'
          . " VALUES (:first, :last, :user_id, :password_hash, :email, :balance, NOW(), :question, :answer, :notice, '', :level, :locked)",
        )->execute([
          'first' => $form->first,
          'last' => $form->last,
          'user_id' => $form->userId,
          'password_hash' => HashPassword::of($form->password),
          'email' => $form->email,
          'balance' => $form->balance,
          'question' => $form->question,
          'answer' => $form->answer,
          'notice' => $form->notice,
          'level' => $form->level,
          'locked' => $form->locked,
        ]);
        (new RecordAccountUpdate($this->database))($recordedBy, 'create', $form);
        return true;
      });
    } catch (PDOException $exception) {
      return IsDuplicateKey::of($exception) ? false : throw $exception;
    }
  }
}
