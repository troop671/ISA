<?php

declare(strict_types=1);

namespace Troop671\Isa;

enum RecoveryStep
{
  case IdentifyUser;
  case AnswerQuestion;
  case ChoosePassword;
  case Changed;
  case Breach;
}
