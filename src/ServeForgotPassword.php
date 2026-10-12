<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ServeForgotPassword implements Page
{
  public function __invoke(Environment $environment, Request $request, RenderPage $render): string
  {
    $cycled = $request->form('cycled') !== '';
    if ($cycled) {
      $_SESSION['RecoveryUserId'] = $request->form('user_id');
      $_SESSION['RecoveryAnswered'] = false;
    }
    $userId = (string) ($_SESSION['RecoveryUserId'] ?? '');
    $database = ConnectDatabase::to($environment);
    $user = $userId === '' ? null : (new FindUser($database))->byUserId($userId);
    $answerable = $user !== null && $user->locked === 'no' && $user->answer !== '';
    $answer = $request->form('answer_entered');
    if ($answerable && $answer !== '' && hash_equals($user->answer, $answer)) {
      $_SESSION['RecoveryAnswered'] = true;
    }
    $answered = $answerable && ($_SESSION['RecoveryAnswered'] ?? false) === true;
    $first = $request->form('password_1');
    $changed = $answered && $first !== '' && $first === $request->form('password_2');
    if ($changed) {
      (new ChangePassword($database))($user->id, $first);
      unset($_SESSION['RecoveryUserId'], $_SESSION['RecoveryAnswered']);
    }
    $step = match (true) {
      $user !== null && $user->locked === 'yes' => RecoveryStep::Breach,
      $changed => RecoveryStep::Changed,
      $answered => RecoveryStep::ChoosePassword,
      CountFailedAttempts::current() === 3 => RecoveryStep::Breach,
      $answerable => RecoveryStep::AnswerQuestion,
      default => RecoveryStep::IdentifyUser,
    };
    if ($step === RecoveryStep::AnswerQuestion && CountFailedAttempts::normalized() < 3) {
      CountFailedAttempts::record();
    }
    if ($step === RecoveryStep::Breach) {
      (new LockUser($database))->byUserId($userId);
      return $render('transfer', ['title' => 'Untitled', 'seconds' => 0, 'url' => 'logout.php?locked=1', 'text' => '']);
    }
    return $render('forgot_password', [
      'step' => $step,
      'question' => $user?->question ?? '',
      'error' => match (true) {
        !$cycled || $step !== RecoveryStep::IdentifyUser => null,
        $user === null => 'User ID not found.',
        default => 'Account has no available Question and Answer.',
      },
    ]);
  }
}
