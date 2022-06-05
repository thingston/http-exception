<?php

declare(strict_types=1);

namespace Thingston\Http\Exception;

final class UnavailableForLegalReasonsException extends HttpException
{
    public const STATUS_CODE = 451;
    public const REASON_PHRASE = 'Unavailable For Legal Reasons';
}
