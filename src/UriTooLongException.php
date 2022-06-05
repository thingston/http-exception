<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class UriTooLongException extends HttpException
{
    public const STATUS_CODE = 414;
    public const REASON_PHRASE = 'URI Too Long';
}
