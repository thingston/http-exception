<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class NotFoundException extends HttpException
{
    public const STATUS_CODE = 404;
    public const REASON_PHRASE = 'Not Found';
}
