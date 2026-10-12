<?php

declare(strict_types=1);

namespace Troop671\Isa;

enum SmtpEncryption: string
{
  case Smtps = 'smtps';
  case StartTls = 'starttls';
  case None = 'none';
}
