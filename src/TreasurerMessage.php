<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class TreasurerMessage
{
  public function __construct(public string $subject, public string $summary, public string $body)
  {
  }
}
