<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeEmailUpdate implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    $database = ConnectDatabase::to($environment);
    $resumption = (new ResumeSession($database, $environment->sessionIdleSeconds))();
    $user = $resumption->user;
    if ($resumption->status !== SessionStatus::Active || $user === null) {
      return (new ServeTransfer())($resumption->status, $render, 'logout.php?timeout=1');
    }
    $close = $request->either('close') !== '' ? $request->either('close') : '0';
    $given = $request->either('user_email_given');
    $yes = $request->form('yes') === 'yes';
    $verdict = $yes && $given !== '' ? ClassifyEmail::of($given) : null;
    if ($verdict === EmailVerdict::Spam) {
      (new LockUser($database))->byId($user->id);
      return (new ServeTransfer())(SessionStatus::Locked, $render, 'logout.php?timeout=1');
    }
    if ($verdict === EmailVerdict::Valid) {
      (new ChangeEmail($database))($user->id, $given);
    }
    return $render('email_update', [
      'view' => match (true) {
        $close === '2' => 'close',
        $verdict === EmailVerdict::Valid || $request->query('pass') === '1' => 'updated',
        $yes || $request->form('no') === 'no' => 'unchanged',
        $close === '0' => 'question',
        default => 'close',
      },
      'given' => $given,
      'user' => $user,
      'refreshSeconds' => $environment->sessionIdleSeconds + 3,
    ]);
  }
}
