<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PDO;

final readonly class ServeContactTreasurer
{
  public function __invoke(User $user, Request $request, PDO $database, RenderPage $render, Environment $environment): PanelOutcome
  {
    $name = $user->name();
    $useEmail = $request->form('use_email');
    $given = $request->form('user_email_given');
    $store = $request->form('store_email_given') === 'yes';
    $amount = $request->form('amount');
    $giveTo = in_array($request->form('give_to'), ['Troop 671', $name], true) ? $request->form('give_to') : '';
    $event = $request->form('event');
    $comments = $request->form('comments');
    $cycled = $request->form('cycled') === 'yes';
    $verdict = match (true) {
      $useEmail === 'account' => EmailVerdict::Valid,
      $useEmail === 'given' && $given !== '' => ClassifyEmail::of($given),
      default => null,
    };
    if ($verdict === EmailVerdict::Spam) {
      (new LockUser($database))->byId($user->id);
      return new PanelOutcome('', locked: true);
    }
    $filled = count(array_filter([$amount, $giveTo, $event], static fn (string $value): bool => $value !== ''));
    $withdrawal = $cycled && $filled === 3;
    $incomplete = $cycled && $filled > 0 && $filled < 3;
    $commented = $cycled && $comments !== '';
    $send = $verdict === EmailVerdict::Valid && ($withdrawal || $commented) && !$incomplete;
    if (!$send) {
      return new PanelOutcome($render('panel_contact_form', [
        'user' => $user,
        'name' => $name,
        'useAccount' => $useEmail !== 'given',
        'useGiven' => $useEmail === 'given',
        'given' => $given,
        'amount' => $amount,
        'giveTo' => $giveTo,
        'event' => $event,
        'comments' => $comments,
        'cycled' => $cycled,
        'nothingEntered' => $cycled && $filled === 0 && $comments === '',
        'emailError' => ($useEmail === 'given' && $given === '') || $verdict === EmailVerdict::Invalid,
        'toError' => $cycled && $filled > 0 && $giveTo === '',
        'amountError' => $cycled && $filled > 0 && $amount === '',
        'forError' => $cycled && $filled > 0 && $event === '',
      ]));
    }
    $treasurerRequest = new TreasurerRequest(
      user: $user,
      replyAddress: $useEmail === 'given' ? $given : $user->email,
      amount: $amount,
      giveTo: $giveTo,
      event: $event,
      comments: $comments,
      withdrawal: $withdrawal,
      commented: $commented,
      sentAt: time(),
    );
    $message = (new ComposeTreasurerMessage($render))($treasurerRequest);
    $treasurers = (new ListUsers($database))->atLevel('treasurer');
    $failures = (new SendTreasurerMessage($environment, dirname(__DIR__) . '/BSA_Logo.jpg'))($message, $treasurerRequest, $treasurers);
    $storeGiven = $useEmail === 'given' && $store;
    if ($storeGiven) {
      (new ChangeEmail($database))($user->id, $given);
    }
    return new PanelOutcome($render('panel_contact_sent', [
      'popup' => match (true) {
        $storeGiven => 'update_email.php?pass=1&close=1',
        $useEmail === 'given' && $given !== $user->email => 'update_email.php?user_email_given=' . rawurlencode($given),
        default => null,
      },
      'succeeded' => $treasurers !== [] && $failures === [],
      'failures' => $failures,
      'withdrawal' => $withdrawal,
      'subject' => $message->subject,
      'summary' => $message->summary,
      'sentAt' => FormatServerTime::of($treasurerRequest->sentAt),
      'treasurerAddress' => $environment->treasurerAddress,
    ]));
  }
}
