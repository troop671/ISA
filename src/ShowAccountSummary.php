<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ShowAccountSummary
{
  public function __invoke(User $user, RenderPage $render): PanelOutcome
  {
    return new PanelOutcome($render('panel_summary', ['user' => $user]));
  }
}
