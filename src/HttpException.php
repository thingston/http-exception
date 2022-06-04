<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

use RuntimeException;
use Throwable;

class HttpException extends RuntimeException implements HttpExceptionInterface
{
    public const STATUS_CODE = 500;
    public const REASON_PHRASE = 'Internal Server Error';

    private string $reasonPhrase;

    /**
     * @param string $message
     * @param array<string, string|string[]> $details
     * @param array<string, string|string[]> $headers
     * @param int|null $code
     * @param string|null $reasonPhrase
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message,
        private array $details = [],
        private array $headers = [],
        ?int $code = null,
        ?string $reasonPhrase = null,
        ?Throwable $previous = null
    ) {
        if (null === $code) {
            $code = static::STATUS_CODE;
        }

        parent::__construct($message, $code, $previous);

        $this->details = $details;
        $this->headers = $headers;
        $this->reasonPhrase = $reasonPhrase ?? static::REASON_PHRASE;

        if (400 > $code || 600 <= $code) {
            throw new self(
                'Status code must be between 400 and 599.',
                [],
                $headers,
                self::STATUS_CODE,
                self::REASON_PHRASE,
                $this
            );
        }
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
