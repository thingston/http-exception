<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class BadGatewayException extends HttpException
{
    public const STATUS_CODE = 502;
    public const REASON_PHRASE = 'Bad Gateway';
}
