<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeIndex implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    return $render('transfer', ['title' => 'Untitled', 'seconds' => 0, 'url' => 'login.php', 'text' => '']);
  }
}
