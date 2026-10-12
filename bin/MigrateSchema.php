<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Troop671\Isa\ConnectDatabase;
use Troop671\Isa\MigrateSchema;
use Troop671\Isa\ReadEnvironment;
use Troop671\Isa\ReportFailure;

ReportFailure::forCommand();
array_map(
  static fn (array $step): int|false => file_put_contents('php://stdout', json_encode($step, JSON_UNESCAPED_SLASHES) . "\n"),
  (new MigrateSchema(ConnectDatabase::to(ReadEnvironment::fromProcess())))(),
);
