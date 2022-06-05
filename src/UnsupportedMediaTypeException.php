<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class UnsupportedMediaTypeException extends HttpException
{
    public const STATUS_CODE = 415;
    public const REASON_PHRASE = 'Unsupported Media Type';
}
