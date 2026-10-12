<?php

declare(strict_types=1);

namespace Troop671\Isa;

final class RunPage
{
  public static function serve(Page $page): void
  {
    ReportFailure::forPage();
    $environment = ReadEnvironment::fromProcess();
    StartSession::start();
    $request = Request::fromGlobals();
    $render = new RenderPage(dirname(__DIR__) . '/templates', ProtectForm::token());
    $body = $page($environment, $request, $render);
    header('Content-Type: text/html; charset=UTF-8');
    echo $body;
  }
}
