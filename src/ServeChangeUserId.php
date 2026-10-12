<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeChangeUserId
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render): PanelOutcome
  {
    $first = $request->form('user_id_1');
    $second = $request->form('user_id_2');
    $matched = $first !== '' && $first === $second;
    $unique = $matched && (new FindUser($database))->byUserId($first) === null;
    $updated = $unique && (new ChangeUserId($database))($user->id, $first);
    return new PanelOutcome($render('panel_change_user_id', [
      'first' => $updated ? '' : $first,
      'second' => $updated ? '' : $second,
      'message' => match (true) {
        $updated => 'User ID successfully updated.',
        $matched => 'Non-Unique User ID; Please try again...',
        $first !== '' => 'Error; Please try again...',
        default => null,
      },
    ]));
  }
}
