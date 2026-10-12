<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Troop671\Isa\ReportFailure;
use Troop671\Isa\WriteHtaccess;

ReportFailure::forCommand();
WriteHtaccess::to(dirname(__DIR__) . '/.htaccess');
file_put_contents('php://stdout', json_encode(['Event' => 'HtaccessWritten', 'Path' => dirname(__DIR__) . '/.htaccess']) . "\n");
