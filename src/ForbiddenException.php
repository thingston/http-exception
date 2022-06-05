<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class ForbiddenException extends HttpException
{
    public const STATUS_CODE = 403;
    public const REASON_PHRASE = 'Forbidden';
}
