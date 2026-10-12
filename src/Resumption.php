<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class Resumption
{
  public function __construct(public SessionStatus $status, public ?User $user)
  {
  }
}
