<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

interface ExceptionRendererInterface
{
    public const DEFAULT_MESSAGE = 'An error has occured.';

    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array;

    public function render(Throwable $exception, bool $debug = false, ?string $defaultMessage = null): string;
}
