<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class TooManyRequestsException extends HttpException
{
    public const STATUS_CODE = 429;
    public const REASON_PHRASE = 'Too Many Requests';
}
