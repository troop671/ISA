<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeChangeQuestion
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render): PanelOutcome
  {
    $first = $request->form('question_1');
    $second = $request->form('question_2');
    $updated = $first !== '' && $first === $second;
    if ($updated) {
      (new ChangeQuestion($database))($user->id, $first);
    }
    $current = $updated ? ((new FindUser($database))->byId($user->id) ?? $user) : $user;
    return new PanelOutcome($render('panel_change_question', [
      'user' => $current,
      'first' => $updated ? '' : $first,
      'second' => $updated ? '' : $second,
      'message' => match (true) {
        $updated => 'Question successfully updated.',
        $first !== '' => 'Error; Please try again..',
        default => null,
      },
    ]));
  }
}
