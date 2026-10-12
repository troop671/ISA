<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeChangeEmail
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render): PanelOutcome
  {
    $first = $request->form('email_1');
    $matched = $first !== '' && $first === $request->form('email_2');
    $verdict = $matched ? ClassifyEmail::of($first) : null;
    if ($verdict === EmailVerdict::Spam) {
      (new LockUser($database))->byId($user->id);
      return new PanelOutcome('', locked: true);
    }
    if ($verdict === EmailVerdict::Valid) {
      (new ChangeEmail($database))($user->id, $first);
    }
    return new PanelOutcome($render('panel_change_email', [
      'message' => match (true) {
        $verdict === EmailVerdict::Valid => 'E-mail successfully updated.',
        $verdict === EmailVerdict::Invalid => 'Please enter a valid email.',
        $first !== '' && !$matched => 'Error; Please try again..',
        default => null,
      },
    ]));
  }
}
