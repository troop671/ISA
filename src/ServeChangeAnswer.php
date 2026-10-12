<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeChangeAnswer
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render): PanelOutcome
  {
    $first = $request->form('answer_1');
    $updated = $first !== '' && $first === $request->form('answer_2');
    if ($updated) {
      (new ChangeAnswer($database))($user->id, $first);
    }
    $current = $updated ? ((new FindUser($database))->byId($user->id) ?? $user) : $user;
    return new PanelOutcome($render('panel_change_answer', [
      'user' => $current,
      'message' => match (true) {
        $updated => 'Answer successfully updated.',
        $first !== '' => 'Error; Please try again...',
        default => null,
      },
    ]));
  }
}
