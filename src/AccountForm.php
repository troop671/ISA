<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class AccountForm
{
  public function __construct(
    public string $first,
    public string $last,
    public string $userId,
    public string $password,
    public string $email,
    public string $notice,
    public string $balance,
    public string $question,
    public string $answer,
    public string $level,
    public string $locked,
  ) {
  }

  public static function fromRequest(Request $request): self
  {
    return new self(
      first: $request->form('first'),
      last: $request->form('last'),
      userId: $request->form('edit_user_id'),
      password: $request->form('password'),
      email: $request->form('email'),
      notice: $request->form('notice'),
      balance: $request->form('balance'),
      question: $request->form('question'),
      answer: $request->form('answer'),
      level: $request->form('level') === 'treasurer' ? 'treasurer' : 'user',
      locked: $request->form('locked') === 'yes' ? 'yes' : 'no',
    );
  }
}
