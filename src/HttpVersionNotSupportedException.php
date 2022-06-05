<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class HttpVersionNotSupportedException extends HttpException
{
    public const STATUS_CODE = 505;
    public const REASON_PHRASE = 'HTTP Version Not Supported';
}
