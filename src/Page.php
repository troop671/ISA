<?php

declare(strict_types=1);

namespace Troop671\Isa;

interface Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string;
}
