<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class GoneException extends HttpException
{
    public const STATUS_CODE = 410;
    public const REASON_PHRASE = 'Gone';
}
