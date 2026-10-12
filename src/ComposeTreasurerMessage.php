<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class ComposeTreasurerMessage
{
  public function __construct(private RenderPage $render)
  {
  }

  public function __invoke(TreasurerRequest $request): TreasurerMessage
  {
    $values = [
      'request' => $request,
      'name' => $request->user->name(),
      'sentAt' => FormatServerTime::of($request->sentAt),
    ];
    $summary = ($this->render)('mail_summary', $values);
    return new TreasurerMessage(
      subject: "re: {$request->user->name()}'s BSA TROOP 671 ISA ACCOUNT",
      summary: $summary,
      body: ($this->render)('mail_body', $values + ['summary' => $summary]),
    );
  }
}
