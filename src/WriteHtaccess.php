<?php

declare(strict_types=1);

namespace Troop671\Isa;

use RuntimeException;

final class WriteHtaccess
{
  private const string ALLOWLIST = <<<'HTACCESS'
    Options -Indexes
    DirectoryIndex index.php
    <IfModule mod_expires.c>
      ExpiresActive Off
    </IfModule>
    Header always set Cache-Control "private, no-store, max-age=0"
    Header always unset Expires
    Header always unset Pragma
    Require all denied
    <If "%{REQUEST_URI} =~ m#^/ISA/(index\.php|login\.php|logout\.php|forgot_password\.php|xaccount_menu\.php|update_email\.php|treasurer_menu\.php|BSA_Logo\.jpg)?$#">
      Require all granted
    </If>

    HTACCESS;

  public static function to(string $path): void
  {
    ReadEnvironment::fromProcess();
    $values = array_combine(ReadEnvironment::NAMES, array_map(static fn (string $name): string => (string) getenv($name), ReadEnvironment::NAMES));
    $unrepresentable = array_keys(array_filter($values, static fn (string $value): bool => preg_match('/^[\x20-\x7E]*$/', $value) !== 1 || str_contains($value, '"') || str_contains($value, '\\') || str_contains($value, '${')));
    if ($unrepresentable !== []) {
      throw new RuntimeException('Environment variables cannot be written to .htaccess, because they contain a double quote, a backslash, "${" or a character outside printable ASCII: ' . implode(', ', $unrepresentable));
    }
    $contents = self::ALLOWLIST . implode('', array_map(static fn (string $name, string $value): string => "SetEnv {$name} \"{$value}\"\n", array_keys($values), $values));
    $temporary = $path . '.' . bin2hex(random_bytes(8));
    if (file_put_contents($temporary, $contents) === false || !chmod($temporary, 0644) || !rename($temporary, $path)) {
      throw new RuntimeException('Could not write ' . $path);
    }
  }
}
