<?php

declare(strict_types=1);

namespace Troop671\Isa;

enum SessionStatus
{
  case Active;
  case Missing;
  case Expired;
  case Locked;
}
