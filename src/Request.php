<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class Request
{
  public function __construct(private array $query, private array $form)
  {
  }

  public static function fromGlobals(): self
  {
    $posted = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    $accepted = $posted && ProtectForm::accepts($_POST);
    if ($posted && !$accepted) {
      ReportFailure::write(['Event' => 'FormRejected', 'Reason' => 'FormTokenMismatch', 'Uri' => (string) ($_SERVER['REQUEST_URI'] ?? '')]);
    }
    return new self($_GET, $accepted ? $_POST : []);
  }

  public function query(string $name): string
  {
    return is_string($this->query[$name] ?? null) ? $this->query[$name] : '';
  }

  public function form(string $name): string
  {
    return is_string($this->form[$name] ?? null) ? $this->form[$name] : '';
  }

  public function either(string $name): string
  {
    return $this->form($name) !== '' ? $this->form($name) : $this->query($name);
  }
}
