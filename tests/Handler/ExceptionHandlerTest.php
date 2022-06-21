<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Handler;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Thingston\Http\Exception\Handler\ExceptionHandler;
use Thingston\Http\Exception\InternalServerErrorException;

final class ExceptionHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new InternalServerErrorException('Some error');

        $handler = new ExceptionHandler();

        $response = $handler->handle($request, $exception);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
