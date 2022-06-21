<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

class PlainTextExceptionRenderer implements ExceptionRendererInterface
{
    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['text/plain'];
    }

    public function render(Throwable $exception, bool $debug = false): string
    {
        return $this->renderException($exception, $debug);
    }

    private function renderTitle(Throwable $exception): string
    {
        return ('' !== $exception->getMessage()
            ? $exception->getMessage() : 'An error ocurred') . PHP_EOL;
    }

    private function renderException(Throwable $exception, bool $debug = false): string
    {
        $text = $this->renderTitle($exception);

        if ($debug) {
            $text .= PHP_EOL;
            $text .= 'Code: ' . $exception->getCode() . PHP_EOL;
            $text .= 'File: ' . $exception->getFile() . PHP_EOL;
            $text .= 'Line: ' . $exception->getLine() . PHP_EOL;
            $text .= PHP_EOL;
            $text .= $exception->getTraceAsString() . PHP_EOL;

            if ($exception->getPrevious()) {
                $text .= $this->renderException($exception->getPrevious(), true);
            }
        }

        return $text;
    }
}
