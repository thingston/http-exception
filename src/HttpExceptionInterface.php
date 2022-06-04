<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

use Throwable;

interface HttpExceptionInterface extends Throwable
{
    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return string
     */
    public function getReasonPhrase(): string;

    /**
     * @return array<string, string|string[]>
     */
    public function getHeaders(): array;

    /**
     * @return array<string, string|string[]>
     */
    public function getDetails(): array;
}
