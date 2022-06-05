<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class MethodNotAllowedException extends HttpException
{
    public const STATUS_CODE = 405;
    public const REASON_PHRASE = 'Method Not Allowed';
}
