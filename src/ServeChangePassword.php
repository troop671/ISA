<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeChangePassword
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render): PanelOutcome
  {
    $first = $request->form('password_1');
    $matched = $first !== '' && $first === $request->form('password_2');
    $changed = $matched ? (new ChangePassword($database))($user->id, $first) : null;
    if ($changed !== null) {
      StartSession::refreshCredential($changed);
    }
    return new PanelOutcome($render('panel_change_password', [
      'message' => match (true) {
        $changed !== null => 'Password successfully updated.',
        $first !== '' => 'Error; Please try again.',
        default => null,
      },
    ]), user: $changed);
  }
}
