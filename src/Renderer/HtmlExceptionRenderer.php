<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

class HtmlExceptionRenderer implements ExceptionRendererInterface
{
    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['text/html'];
    }

    public function render(Throwable $exception, bool $debug = false): string
    {
        return sprintf(
            '<html>'
                . '<head><title>%s</title></head>'
                . '<body>%s</body>'
                . '</html>',
            $this->renderTitle($exception),
            $this->renderBody($exception, $debug)
        );
    }

    private function renderTitle(Throwable $exception): string
    {
        return '' !== $exception->getMessage()
            ? $exception->getMessage() : 'An error ocurred';
    }

    private function renderBody(Throwable $exception, bool $debug = false): string
    {
        $html = sprintf('<h1>%s</h1>', $this->renderTitle($exception));

        if ($debug) {
            $html .= sprintf(
                '<dl>'
                    . '<dt>Code</dt><dd>%d</dd>'
                    . '<dt>File</dt><dd>%s</dd>'
                    . '<dt>Line</dt><dd>%d</dd>'
                    . '</dl>',
                $exception->getCode(),
                $exception->getFile(),
                $exception->getLine()
            );

            $html .= $this->renderTrace($exception);

            if ($exception->getPrevious()) {
                $html .= $this->renderPrevious($exception->getPrevious());
            }
        }

        return $html;
    }

    private function renderTrace(Throwable $exception): string
    {
        return sprintf('<pre>%s</pre>', $exception->getTraceAsString());
    }

    private function renderPrevious(Throwable $exception): string
    {
        $html = sprintf('<h2>%s</h2>%s', $this->renderTitle($exception), $this->renderTrace($exception));

        if ($exception->getPrevious()) {
            $html .= $this->renderPrevious($exception->getPrevious());
        }

        return $html;
    }
}
