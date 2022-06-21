<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

class JsonExceptionRenderer implements ExceptionRendererInterface
{
    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['application/json'];
    }

    public function render(Throwable $exception, bool $debug = false): string
    {
        return json_encode($this->renderException($exception, $debug)) ?: $this->renderTitle($exception);
    }

    private function renderTitle(Throwable $exception): string
    {
        return '' !== $exception->getMessage()
            ? $exception->getMessage() : 'An error ocurred';
    }

    /**
     * @param Throwable $exception
     * @param bool $debug
     * @return array<string, mixed>
     */
    private function renderException(Throwable $exception, bool $debug = false): array
    {
        $data = [
            'message' => $this->renderTitle($exception),
        ];

        if ($debug) {
            $data['code'] = $exception->getCode();
            $data['file'] = $exception->getFile();
            $data['line'] = $exception->getLine();
            $data['trace'] = $exception->getTrace();

            if ($exception->getPrevious()) {
                $data['previous'] = $this->renderException($exception->getPrevious());
            }
        }

        return $data;
    }
}
