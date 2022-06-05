<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class RequestHeaderFieldsTooLargeException extends HttpException
{
    public const STATUS_CODE = 431;
    public const REASON_PHRASE = 'Request Header Fields Too Large';
}
