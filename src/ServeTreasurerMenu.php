<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeTreasurerMenu implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    $database = ConnectDatabase::to($environment);
    $resumption = (new ResumeSession($database, $environment->sessionIdleSeconds))();
    $treasurer = $resumption->user;
    if ($resumption->status !== SessionStatus::Active || $treasurer === null || $treasurer->level !== 'treasurer') {
      return (new ServeTransfer())($resumption->status === SessionStatus::Active ? SessionStatus::Missing : $resumption->status, $render, 'logout.php?timeout=1');
    }
    $count = max(0, (int) $request->form('cnt'));
    if ($count > 0 && $request->form('process_all_b') === 'submit all') {
      (new UpdateBalances($database))(array_column(
        array_map(static fn (int $index): array => [(int) $request->form("edit_all_id{$index}"), $request->form("edit_all_b{$index}")], range(0, $count - 1)),
        1,
        0,
      ));
    }
    if ($request->form('send_gm') === 'Send GM') {
      (new SendGeneralMessage($database))($request->form('gm'));
    }
    $form = AccountForm::fromRequest($request);
    $creating = $request->form('create') === 'create account';
    $updating = $request->form('update') === 'update';
    $selectedId = (int) $request->form('selected_id');
    $existing = $form->userId === '' ? null : (new FindUser($database))->byUserId($form->userId);
    $userIdCheck = match (true) {
      $form->userId === '' => null,
      $creating => $existing === null,
      $updating => $existing === null || $existing->id === $selectedId,
      default => null,
    };
    $emailVerdict = $form->email === '' ? EmailVerdict::Invalid : ClassifyEmail::of($form->email);
    if (($creating || $updating) && $emailVerdict === EmailVerdict::Spam) {
      (new LockUser($database))->byId($treasurer->id);
      return (new ServeTransfer())(SessionStatus::Locked, $render, 'logout.php?timeout=1');
    }
    $valid = $userIdCheck === true && $emailVerdict === EmailVerdict::Valid;
    $saved = match (true) {
      $creating && $valid => (new CreateAccount($database))($treasurer->id, $form),
      $updating && $valid => (new UpdateAccount($database))($treasurer->id, $selectedId, $form),
      default => false,
    };
    $nonUnique = $userIdCheck === false || (($creating || $updating) && $valid && !$saved);
    $emailInvalid = $emailVerdict === EmailVerdict::Invalid;
    if ($updating && $request->form('delete_acc') === 'delete') {
      (new DeleteAccount($database))($selectedId);
    }
    $editingId = $request->form('panel_selection') === 'edit'
      ? (int) $request->form('selected_user')
      : (($updating && ($emailInvalid || $nonUnique)) ? $selectedId : 0);
    $users = new ListUsers($database);
    return $render('treasurer_menu', [
      'treasurer' => $treasurer,
      'refreshSeconds' => $environment->sessionIdleSeconds + 3,
      'generalMessage' => $request->form('create_gm') === 'create GM' ? $users->firstGeneralMessage() : null,
      'balances' => $request->form('edit_all_balances') === 'edit all balances' ? $users->atLevel('user') : null,
      'creating' => $request->form('create_account') === 'create account' || ($creating && ($emailInvalid || $nonUnique)),
      'form' => $form,
      'createNonUnique' => $creating && $nonUnique,
      'createEmailInvalid' => $creating && $emailInvalid,
      'editing' => $editingId > 0 ? (new FindUser($database))->byId($editingId) : null,
      'updateNonUnique' => $updating && $nonUnique,
      'updateEmailInvalid' => $updating && $emailInvalid,
      'scouts' => $users->atLevel('user'),
      'treasurers' => $users->atLevel('treasurer'),
    ]);
  }
}
