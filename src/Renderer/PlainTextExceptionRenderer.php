<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

final class PlainTextExceptionRenderer implements ExceptionRendererInterface
{
    use TitleRendererTrait;

    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['text/plain'];
    }

    public function render(Throwable $exception, bool $debug = false, ?string $defaultMessage = null): string
    {
        $title = $this->renderTitle($exception, $debug, $defaultMessage ?? self::DEFAULT_MESSAGE);

        return $this->renderException($exception, $debug, $title);
    }

    private function renderException(Throwable $exception, bool $debug, string $defaultMessage): string
    {
        if (false === $debug) {
            return $defaultMessage;
        }

        $text = $defaultMessage . PHP_EOL;

        $text .= PHP_EOL;
        $text .= 'Code: ' . $exception->getCode() . PHP_EOL;
        $text .= 'File: ' . $exception->getFile() . PHP_EOL;
        $text .= 'Line: ' . $exception->getLine() . PHP_EOL;
        $text .= PHP_EOL;
        $text .= $exception->getTraceAsString() . PHP_EOL;

        if (null !== $previous = $exception->getPrevious()) {
            $text .= $this->renderException($previous, true, $previous->getMessage());
        }

        return $text;
    }
}
