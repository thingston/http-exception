<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class UnauthorizedException extends HttpException
{
    public const STATUS_CODE = 401;
    public const REASON_PHRASE = 'Unauthorized';
}
