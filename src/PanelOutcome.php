<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class PanelOutcome
{
  public function __construct(public string $html, public bool $locked = false, public ?User $user = null)
  {
  }
}
