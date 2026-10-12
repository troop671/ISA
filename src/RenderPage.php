<?php

declare(strict_types=1);

namespace Troop671\Isa;

final readonly class RenderPage
{
  public function __construct(private string $templates, private string $formToken)
  {
  }

  public function __invoke(string $template, array $values = []): string
  {
    $escape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $paragraphs = static fn (mixed $value): string => nl2br($escape($value), false);
    $checked = static fn (bool $on): string => $on ? 'checked' : '';
    $formToken = "<input type='hidden' name='form_token' value='" . $escape($this->formToken) . "'>";
    $render = $this;
    return (static function (string $__template, array $__values) use ($escape, $paragraphs, $checked, $formToken, $render): string {
      extract($__values, EXTR_SKIP);
      ob_start();
      require $__template;
      return (string) ob_get_clean();
    })($this->templates . '/' . $template . '.php', $values);
  }
}
