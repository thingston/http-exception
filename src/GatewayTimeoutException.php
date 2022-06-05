<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class GatewayTimeoutException extends HttpException
{
    public const STATUS_CODE = 504;
    public const REASON_PHRASE = 'Gateway Timeout';
}
