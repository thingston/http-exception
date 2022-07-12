<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

trait TitleRendererTrait
{
    private function renderTitle(Throwable $exception, bool $debug, string $defaultMessage): string
    {
        if (false === $debug) {
            return $defaultMessage;
        }

        return '' !== $exception->getMessage()
            ? $exception->getMessage()
            : $defaultMessage;
    }
}
