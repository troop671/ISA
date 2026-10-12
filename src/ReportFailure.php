<?php

declare(strict_types=1);

namespace Troop671\Isa;

use ErrorException;
use Throwable;

final class ReportFailure
{
  public static function forPage(): void
  {
    self::escalateErrors();
    set_exception_handler(static function (Throwable $throwable): void {
      self::write(self::describe($throwable) + ['Uri' => (string) ($_SERVER['REQUEST_URI'] ?? '')]);
      http_response_code(500);
      echo "<html><head><title>Error</title></head><body bgcolor='4A4A4A'><font color='white' face='arial'>Fatal System Error.  Please contact the Treasurer.</font></body></html>";
    });
  }

  public static function forCommand(): void
  {
    self::escalateErrors();
    set_exception_handler(static function (Throwable $throwable): void {
      self::write(self::describe($throwable));
      exit(1);
    });
  }

  public static function write(array $fields): void
  {
    file_put_contents('php://stderr', json_encode($fields, JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE) . "\n");
  }

  private static function describe(Throwable $throwable): array
  {
    return [
      'Event' => 'Failure',
      'Error' => $throwable::class,
      'Message' => $throwable->getMessage(),
      'File' => $throwable->getFile(),
      'Line' => $throwable->getLine(),
    ];
  }

  private static function escalateErrors(): void
  {
    set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
      if ((error_reporting() & $severity) === 0) {
        return false;
      }
      throw new ErrorException($message, 0, $severity, $file, $line);
    });
  }
}
