<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class PreconditionFailedException extends HttpException
{
    public const STATUS_CODE = 412;
    public const REASON_PHRASE = 'Precondition Failed';
}
