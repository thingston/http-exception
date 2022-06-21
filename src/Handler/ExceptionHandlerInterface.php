<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Thingston\Http\Exception\Renderer\ExceptionRendererResolverInterface;
use Throwable;

interface ExceptionHandlerInterface
{
    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface;
}
