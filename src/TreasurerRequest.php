<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class TreasurerRequest
{
  public function __construct(
    public User $user,
    public string $replyAddress,
    public string $amount,
    public string $giveTo,
    public string $event,
    public string $comments,
    public bool $withdrawal,
    public bool $commented,
    public int $sentAt,
  ) {
  }
}
