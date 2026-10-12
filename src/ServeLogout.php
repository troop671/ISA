<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeLogout implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    StartSession::end();
    $flag = match (true) {
      $request->query('pass_change') !== '' => 'pass_change',
      $request->query('locked') !== '' => 'locked',
      $request->query('timeout') !== '' => 'timeout',
      default => 'logout',
    };
    return $render('transfer', ['title' => 'Untitled', 'seconds' => 0, 'url' => "login.php?{$flag}=1", 'text' => '']);
  }
}
