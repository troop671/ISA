<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class User
{
  public function __construct(
    public int $id,
    public string $first,
    public string $last,
    public string $userId,
    public string $passwordHash,
    public string $email,
    public string $balance,
    public string $lastUpdate,
    public string $question,
    public string $answer,
    public string $notice,
    public string $gm,
    public string $level,
    public string $locked,
  ) {
  }

  public static function fromRow(array $row): self
  {
    return new self(
      id: (int) $row['id'],
      first: (string) $row['first'],
      last: (string) $row['last'],
      userId: (string) $row['user_id'],
      passwordHash: (string) $row['password_hash'],
      email: (string) $row['email'],
      balance: (string) $row['balance'],
      lastUpdate: (string) ($row['last_update'] ?? ''),
      question: (string) $row['question'],
      answer: (string) $row['answer'],
      notice: (string) $row['notice'],
      gm: (string) $row['gm'],
      level: (string) $row['level'],
      locked: (string) $row['locked'],
    );
  }

  public function name(): string
  {
    return $this->first . ' ' . $this->last;
  }

  public function credential(): string
  {
    return hash('sha256', $this->passwordHash);
  }
}
