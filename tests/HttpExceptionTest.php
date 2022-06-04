<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\HttpExceptionInterface;

final class HttpExceptionTest extends TestCase
{
    public function testDefaultException(): void
    {
        $message = 'Some error message.';
        $exception = new HttpException($message);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame(HttpException::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame(HttpException::STATUS_CODE, $exception->getCode());
        $this->assertSame(HttpException::REASON_PHRASE, $exception->getReasonPhrase());
        $this->assertSame([], $exception->getDetails());
        $this->assertSame([], $exception->getHeaders());
        $this->assertNull($exception->getPrevious());
    }

    public function testCustomException(): void
    {
        $message = 'Some error message.';
        $details = ['type' => 'PHPUnit'];
        $headers = ['content-type' => 'text/plain'];
        $code = 400;
        $reason = 'Bad Request';
        $previous = new RuntimeException();

        $exception = new HttpException($message, $details, $headers, $code, $reason, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getStatusCode());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($reason, $exception->getReasonPhrase());
        $this->assertSame($details, $exception->getDetails());
        $this->assertSame($headers, $exception->getHeaders());
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testBadStatusCode(): void
    {
        $this->expectException(HttpExceptionInterface::class);
        new HttpException('Some error', [], [], 200);
    }
}
