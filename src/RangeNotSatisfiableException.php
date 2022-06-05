<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class RangeNotSatisfiableException extends HttpException
{
    public const STATUS_CODE = 416;
    public const REASON_PHRASE = 'Range Not Satisfiable';
}
