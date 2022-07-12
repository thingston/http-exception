<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

final class HtmlExceptionRenderer implements ExceptionRendererInterface
{
    use TitleRendererTrait;

    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['text/html'];
    }

    public function render(Throwable $exception, bool $debug = false, ?string $defaultMessage = null): string
    {
        return sprintf(
            '<html>'
                . '<head><title>%s</title></head>'
                . '<body>%s</body>'
                . '</html>',
            $this->renderTitle($exception, $debug, $defaultMessage ?? self::DEFAULT_MESSAGE),
            $this->renderBody($exception, $debug, $defaultMessage ?? self::DEFAULT_MESSAGE)
        );
    }

    private function renderBody(Throwable $exception, bool $debug, string $defaultMessage): string
    {
        $html = sprintf('<h1>%s</h1>', $this->renderTitle($exception, $debug, $defaultMessage));

        if (false === $debug) {
            return $html;
        }

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

        return $html;
    }

    private function renderTrace(Throwable $exception): string
    {
        return sprintf('<pre>%s</pre>', $exception->getTraceAsString());
    }

    private function renderPrevious(Throwable $exception): string
    {
        $html = sprintf('<h2>%s</h2>%s', $exception->getMessage(), $this->renderTrace($exception));

        if ($exception->getPrevious()) {
            $html .= $this->renderPrevious($exception->getPrevious());
        }

        return $html;
    }
}
