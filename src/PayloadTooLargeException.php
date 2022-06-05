<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class PayloadTooLargeException extends HttpException
{
    public const STATUS_CODE = 413;
    public const REASON_PHRASE = 'Payload Too Large';
}
