<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeTransfer
{
  public function __invoke(SessionStatus $status, RenderPage $render, string $timeoutUrl): string
  {
    return match ($status) {
      SessionStatus::Expired => $render('transfer', ['title' => 'Transfering', 'seconds' => 1, 'url' => $timeoutUrl, 'text' => 'Session Timed Out.  Transfering . . .']),
      SessionStatus::Locked => $render('transfer', ['title' => 'Transfering', 'seconds' => 1, 'url' => 'logout.php?locked=1', 'text' => 'Transfering . . .']),
      default => $render('transfer', ['title' => 'Transfering', 'seconds' => 1, 'url' => 'login.php', 'text' => 'Transfering . . .']),
    };
  }
}
