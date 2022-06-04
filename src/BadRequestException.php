<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class BadRequestException extends HttpException
{
    public const STATUS_CODE = 400;
    public const REASON_PHRASE = 'Bad Request';
}
