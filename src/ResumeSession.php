<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ResumeSession
{
  public function __construct(private PDO $database, private int $idleSeconds)
  {
  }

  public function __invoke(): Resumption
  {
    $id = $_SESSION['UserId'] ?? null;
    $user = is_int($id) ? (new FindUser($this->database))->byId($id) : null;
    $status = match (true) {
      $user === null || !hash_equals($user->credential(), (string) ($_SESSION['Credential'] ?? '')) => SessionStatus::Missing,
      time() - (int) ($_SESSION['LastActive'] ?? 0) > $this->idleSeconds => SessionStatus::Expired,
      $user->locked !== 'no' => SessionStatus::Locked,
      default => SessionStatus::Active,
    };
    if ($status === SessionStatus::Active) {
      $_SESSION['LastActive'] = time();
    }
    return new Resumption($status, $user);
  }
}
