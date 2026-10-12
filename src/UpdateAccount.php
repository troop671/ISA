<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;
use PDOException;

final readonly class UpdateAccount
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(int $recordedBy, int $id, AccountForm $form): bool
  {
    try {
      return RunTransaction::on($this->database, function () use ($recordedBy, $id, $form): bool {
        if ($form->password !== '') {
          $this->database->prepare('UPDATE `users` SET `password_hash` = :hash WHERE `id` = :id')->execute(['hash' => HashPassword::of($form->password), 'id' => $id]);
        }
        $this->database->prepare(
          'UPDATE `users` SET `first` = :first, `last` = :last, `user_id` = :user_id, `email` = :email, `notice` = :notice, `balance` = :balance,'
          . ' `last_update` = NOW(), `question` = :question, `answer` = :answer, `level` = :level, `locked` = :locked WHERE `id` = :id',
        )->execute([
          'first' => $form->first,
          'last' => $form->last,
          'user_id' => $form->userId,
          'email' => $form->email,
          'notice' => $form->notice,
          'balance' => $form->balance,
          'question' => $form->question,
          'answer' => $form->answer,
          'level' => $form->level,
          'locked' => $form->locked,
          'id' => $id,
        ]);
        (new RecordAccountUpdate($this->database))($recordedBy, 'update', $form);
        return true;
      });
    } catch (PDOException $exception) {
      return IsDuplicateKey::of($exception) ? false : throw $exception;
    }
  }
}
