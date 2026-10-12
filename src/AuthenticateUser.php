<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class AuthenticateUser
{
  public function __construct(private PDO $database)
  {
  }

  public function __invoke(string $userId, string $password): ?User
  {
    $user = (new FindUser($this->database))->byUserId($userId);
    return match (true) {
      $user === null => null,
      preg_match('/^[0-9a-f]{40}$/i', $user->passwordHash) === 1 => hash_equals(strtolower($user->passwordHash), sha1($password)) ? $this->rehash($user, $password) : null,
      !password_verify($password, $user->passwordHash) => null,
      password_needs_rehash($user->passwordHash, PASSWORD_ARGON2ID) => $this->rehash($user, $password),
      default => $user,
    };
  }

  private function rehash(User $user, string $password): User
  {
    $statement = $this->database->prepare('UPDATE `users` SET `password_hash` = :replacement WHERE `id` = :id AND `password_hash` = :current');
    $statement->execute(['replacement' => HashPassword::of($password), 'id' => $user->id, 'current' => $user->passwordHash]);
    return (new FindUser($this->database))->byId($user->id) ?? $user;
  }
}
