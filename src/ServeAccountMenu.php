<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeAccountMenu implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    $database = ConnectDatabase::to($environment);
    $resumption = (new ResumeSession($database, $environment->sessionIdleSeconds))();
    $user = $resumption->user;
    if ($resumption->status !== SessionStatus::Active || $user === null) {
      return (new ServeTransfer())($resumption->status, $render, 'login.php?timeout=1');
    }
    $outcome = match (true) {
      $request->form('contact_treas') !== '' || $request->form('send_mail') === 'Send Mail' => (new ServeContactTreasurer())($user, $request, $database, $render, $environment),
      $request->form('change_email') !== '' || $request->form('set_new_email') === 'Set New E-mail' => (new ServeChangeEmail())($user, $request, $database, $render),
      $request->form('change_password') !== '' || $request->form('set_new_password') === 'Set New Password' => (new ServeChangePassword())($user, $request, $database, $render),
      $request->form('change_user_id') === 'Change User ID' || $request->form('set_new_user_id') === 'Set New User ID' => (new ServeChangeUserId())($user, $request, $database, $render),
      $request->form('change_question') === 'Change Question' || $request->form('set_new_question') === 'Set New Question' => (new ServeChangeQuestion())($user, $request, $database, $render),
      $request->form('change_answer') === 'Change Answer' || $request->form('set_new_answer') === 'Set New Answer' => (new ServeChangeAnswer())($user, $request, $database, $render),
      default => (new ShowAccountSummary())($user, $render),
    };
    if ($outcome->locked) {
      return (new ServeTransfer())(SessionStatus::Locked, $render, 'login.php?timeout=1');
    }
    return $render('account_menu', [
      'user' => $user,
      'panel' => $outcome->html,
      'refreshSeconds' => $environment->sessionIdleSeconds + 3,
    ]);
  }
}
