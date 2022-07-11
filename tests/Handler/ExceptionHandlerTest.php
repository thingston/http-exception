<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Handler;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Thingston\Http\Exception\Handler\ExceptionHandler;
use Thingston\Http\Exception\Handler\ExceptionHandlerSettings;
use Thingston\Http\Exception\HttpExceptionInterface;
use Thingston\Http\Exception\InternalServerErrorException;
use Thingston\Http\Exception\NotFoundException;

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

    public function testHandleWithoutLogging(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new InternalServerErrorException('Some error');

        $settings = new ExceptionHandlerSettings([
            ExceptionHandlerSettings::LOG_ERRORS => false,
        ]);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('warning');
        $logger->expects($this->never())->method('error');

        $handler = new ExceptionHandler(
            settings: $settings,
            logger: $logger
        );

        $response = $handler->handle($request, $exception);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testHandleWarning(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new NotFoundException('Some error');

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('warning');
        $logger->expects($this->never())->method('error');

        $handler = new ExceptionHandler(
            logger: $logger
        );

        $response = $handler->handle($request, $exception);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testHandleExceptionWithContentType(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new NotFoundException('Some error', [], ['content-type' => 'text/plain']);

        $handler = new ExceptionHandler();

        $response = $handler->handle($request, $exception);

        $this->assertSame('text/plain', $response->getHeader('content-type')[0]);
    }

    public function testHandleRequestWithAccept(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/', ['accept' => 'text/plain']);
        $exception = new NotFoundException('Some error');

        $handler = new ExceptionHandler();

        $response = $handler->handle($request, $exception);

        $this->assertSame('text/plain', $response->getHeader('content-type')[0]);
    }

    public function testInvalidDefaultRenderer(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new NotFoundException('Some error');

        $handler = new ExceptionHandler(
            settings: new ExceptionHandlerSettings([
                ExceptionHandlerSettings::DEFAULT_RENDERER => 1,
            ])
        );

        $this->expectException(HttpExceptionInterface::class);
        $handler->handle($request, $exception);
    }

    public function testInvalidRenderers(): void
    {
        $request = new ServerRequest('GET', 'http://example.org/');
        $exception = new NotFoundException('Some error');

        $handler = new ExceptionHandler(
            settings: new ExceptionHandlerSettings([
                ExceptionHandlerSettings::RENDERERS => 1,
            ])
        );

        $this->expectException(HttpExceptionInterface::class);
        $handler->handle($request, $exception);
    }
}
