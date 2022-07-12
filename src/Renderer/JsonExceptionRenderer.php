<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Throwable;

final class JsonExceptionRenderer implements ExceptionRendererInterface
{
    use TitleRendererTrait;

    /**
     * @return array<string>
     */
    public static function getMimeTypes(): array
    {
        return ['application/json'];
    }

    public function render(Throwable $exception, bool $debug = false, ?string $defaultMessage = null): string
    {
        if (null === $defaultMessage) {
            $defaultMessage = self::DEFAULT_MESSAGE;
        }

        $title = $this->renderTitle($exception, $debug, $defaultMessage);
        $json = json_encode($this->renderException($exception, $debug, $title));
        $fallback = sprintf('{"message":"%s"}', addslashes($title));

        return $json ?: $fallback;
    }

    /**
     * @param Throwable $exception
     * @param bool $debug
     * @param string $defaultMessage
     * @return array<string, mixed>
     */
    private function renderException(Throwable $exception, bool $debug, string $defaultMessage): array
    {
        $data = [
            'message' => $defaultMessage,
        ];

        if (false === $debug) {
            return $data;
        }

        $data['code'] = $exception->getCode();
        $data['file'] = $exception->getFile();
        $data['line'] = $exception->getLine();
        $data['trace'] = $exception->getTrace();

        if (null !== $previous = $exception->getPrevious()) {
            $data['previous'] = $this->renderException($previous, true, $previous->getMessage());
        }

        return $data;
    }
}
