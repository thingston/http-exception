<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class ExpectationFailedException extends HttpException
{
    public const STATUS_CODE = 417;
    public const REASON_PHRASE = 'Expectation Failed';
}
