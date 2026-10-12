<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeLogin implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    $userId = $request->form('user_id');
    $password = $request->form('password');
    $attempted = $userId !== '' && $password !== '';
    $database = $attempted ? ConnectDatabase::to($environment) : null;
    $user = $database === null ? null : (new AuthenticateUser($database))($userId, $password);
    $attempts = $attempted && $user === null ? CountFailedAttempts::record() : CountFailedAttempts::current();
    $exhausted = $attempted && $user === null && $attempts === 4;
    if ($exhausted) {
      (new LockUser($database))->byUserId($userId);
    }
    $signedIn = $user !== null && $user->locked === 'no';
    if ($signedIn) {
      StartSession::signIn($user);
    }
    return $render('login', [
      'treasurerAddress' => $environment->treasurerAddress,
      'refresh' => match (true) {
        $exhausted => ['seconds' => 0, 'url' => 'logout.php?locked=1'],
        $signedIn && $user->level === 'user' => ['seconds' => 2, 'url' => 'xaccount_menu.php'],
        $signedIn && $user->level === 'treasurer' => ['seconds' => 2, 'url' => 'treasurer_menu.php'],
        default => null,
      },
      'welcome' => $signedIn ? $user->first : null,
      'wrongAuthentication' => $attempted && $user === null,
      'locked' => $request->query('locked') !== '' || ($user !== null && $user->locked === 'yes'),
      'timeout' => $request->query('timeout') !== '',
      'logout' => $request->query('logout') !== '',
    ]);
  }
}
