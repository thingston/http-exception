<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class ServiceUnavailableException extends HttpException
{
    public const STATUS_CODE = 503;
    public const REASON_PHRASE = 'Service Unavailable';
}
