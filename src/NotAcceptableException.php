<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class NotAcceptableException extends HttpException
{
    public const STATUS_CODE = 406;
    public const REASON_PHRASE = 'Not Acceptable';
}
