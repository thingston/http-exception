<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Thingston\Http\Exception\BadGatewayException;
use Thingston\Http\Exception\BadRequestException;
use Thingston\Http\Exception\ExpectationFailedException;
use Thingston\Http\Exception\ForbiddenException;
use Thingston\Http\Exception\GatewayTimeoutException;
use Thingston\Http\Exception\GoneException;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\HttpExceptionInterface;
use Thingston\Http\Exception\HttpVersionNotSupportedException;
use Thingston\Http\Exception\InternalServerErrorException;
use Thingston\Http\Exception\MethodNotAllowedException;
use Thingston\Http\Exception\NotAcceptableException;
use Thingston\Http\Exception\NotFoundException;
use Thingston\Http\Exception\PayloadTooLargeException;
use Thingston\Http\Exception\PreconditionFailedException;
use Thingston\Http\Exception\RangeNotSatisfiableException;
use Thingston\Http\Exception\RequestHeaderFieldsTooLargeException;
use Thingston\Http\Exception\ServiceUnavailableException;
use Thingston\Http\Exception\TooManyRequestsException;
use Thingston\Http\Exception\UnauthorizedException;
use Thingston\Http\Exception\UnavailableForLegalReasonsException;
use Thingston\Http\Exception\UnsupportedMediaTypeException;
use Thingston\Http\Exception\UriTooLongException;

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

    public function testBadRequestException(): void
    {
        $exception = new BadRequestException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testUnauthorizedException(): void
    {
        $exception = new UnauthorizedException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testForbiddenException(): void
    {
        $exception = new ForbiddenException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testNotFoundException(): void
    {
        $exception = new NotFoundException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testMethodNotAllowedException(): void
    {
        $exception = new MethodNotAllowedException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testNotAcceptableException(): void
    {
        $exception = new NotAcceptableException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testGoneException(): void
    {
        $exception = new GoneException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testPreconditionFailedException(): void
    {
        $exception = new PreconditionFailedException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testPayloadTooLargeException(): void
    {
        $exception = new PayloadTooLargeException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testUriTooLongException(): void
    {
        $exception = new UriTooLongException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testUnsupportedMediaTypeException(): void
    {
        $exception = new UnsupportedMediaTypeException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testRangeNotSatisfiableException(): void
    {
        $exception = new RangeNotSatisfiableException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testExpectationFailedException(): void
    {
        $exception = new ExpectationFailedException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testTooManyRequestsException(): void
    {
        $exception = new TooManyRequestsException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testRequestHeaderFieldsTooLargeException(): void
    {
        $exception = new RequestHeaderFieldsTooLargeException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testUnavailableForLegalReasonsException(): void
    {
        $exception = new UnavailableForLegalReasonsException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testInternalServerErrorException(): void
    {
        $exception = new InternalServerErrorException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testBadGatewayException(): void
    {
        $exception = new BadGatewayException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testServiceUnavailableException(): void
    {
        $exception = new ServiceUnavailableException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testGatewayTimeoutException(): void
    {
        $exception = new GatewayTimeoutException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }

    public function testHttpVersionNotSupportedException(): void
    {
        $exception = new HttpVersionNotSupportedException('Some error');

        $this->assertSame($exception::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame($exception::REASON_PHRASE, $exception->getReasonPhrase());
    }
}
