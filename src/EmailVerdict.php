<?php

declare(strict_types=1);

namespace Troop671\Isa;

enum EmailVerdict
{
  case Valid;
  case Invalid;
  case Spam;
}
