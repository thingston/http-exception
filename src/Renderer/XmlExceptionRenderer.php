<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

final class XmlExceptionRenderer implements ExceptionRendererInterface
{
    use TitleRendererTrait;

    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['text/xml'];
    }

    public function render(Throwable $exception, bool $debug = false, ?string $defaultMessage = null): string
    {
        return sprintf(
            '<error>'
                . '<message>%s</message>'
                . '%s'
                . '</error>',
            $this->renderTitle($exception, $debug, $defaultMessage ?? self::DEFAULT_MESSAGE),
            $this->renderBody($exception, $debug)
        );
    }

    private function renderBody(Throwable $exception, bool $debug = false): string
    {
        if (false === $debug) {
            return '';
        }

        $xml = '';

        $xml .= sprintf(
            '<code>%d</code>'
                . '<file>%s</file>'
                . '<line>%d</line>',
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine()
        );

        $xml .= $this->renderTrace($exception);

        if ($exception->getPrevious()) {
            $xml .= $this->renderPrevious($exception->getPrevious());
        }

        return $xml;
    }

    private function renderTrace(Throwable $exception): string
    {
        $xml = '<trace>';

        foreach ($exception->getTrace() as $row) {
            $xml .= '<row>';

            if (isset($row['file'])) {
                $xml .= sprintf('<file>%s</file>', $row['file']);
            }

            if (isset($row['line'])) {
                $xml .= sprintf('<line>%d</line>', $row['line']);
            }

            foreach (['function', 'class', 'type'] as $entry) {
                if (isset($row[$entry])) {
                    $xml .= sprintf('<%s>%s</%s>', $entry, $row[$entry], $entry);
                }
            }

            $xml .= '</row>';
        }

        $xml .= '</trace>';

        return $xml;
    }

    private function renderPrevious(Throwable $exception): string
    {
        $xml = sprintf(
            '<previous><message>%s</message>%s</previous>',
            $exception->getMessage(),
            $this->renderTrace($exception)
        );

        if ($exception->getPrevious()) {
            $xml .= $this->renderPrevious($exception->getPrevious());
        }

        return $xml;
    }
}
