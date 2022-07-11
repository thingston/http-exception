<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Handler;

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Thingston\Http\Exception\HttpExceptionInterface;
use Thingston\Http\Exception\InternalServerErrorException;
use Thingston\Http\Exception\Renderer\ExceptionRendererResolver;
use Thingston\Http\Exception\Renderer\ExceptionRendererResolverInterface;
use Thingston\Http\Exception\Renderer\JsonExceptionRenderer;
use Thingston\Log\LogManager;
use Thingston\Settings\SettingsInterface;
use Throwable;

class ExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(
        private ?SettingsInterface $settings = null,
        private ?LoggerInterface $logger = null,
        private ?ExceptionRendererResolverInterface $resolver = null,
        private ?ResponseFactoryInterface $factory = null
    ) {
        $this->settings = $settings;
        $this->logger = $logger;
        $this->resolver = $resolver;
        $this->factory = $factory;
    }

    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $this->logErrors($request, $exception);

        return $this->createResponse($request, $exception);
    }

    private function getSettings(): SettingsInterface
    {
        if (null === $this->settings) {
            $this->settings = new ExceptionHandlerSettings();
        }

        return $this->settings;
    }

    private function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new LogManager();
        }

        return $this->logger;
    }

    private function getResponseFactory(): ResponseFactoryInterface
    {
        if (null === $this->factory) {
            $this->factory = new HttpFactory();
        }

        return $this->factory;
    }

    private function logErrors(ServerRequestInterface $request, Throwable $exception): void
    {
        $settings = $this->getSettings();

        $logErrors = $settings->has(ExceptionHandlerSettings::LOG_ERRORS)
            && $settings->get(ExceptionHandlerSettings::LOG_ERRORS);

        if (false === $logErrors) {
            return;
        }

        $message = '' !== $exception->getMessage()
            ? $exception->getMessage() : 'Error ' . $exception->getCode();

        $logDetails = $settings->has(ExceptionHandlerSettings::LOG_DETAILS)
            && $settings->get(ExceptionHandlerSettings::LOG_DETAILS);

        $context = $logDetails ? $exception->getTrace() : [];

        if ($exception instanceof HttpExceptionInterface && 500 > $exception->getStatusCode()) {
            $this->getLogger()->warning($message, $context);
        } else {
            $this->getLogger()->error($message, $context);
        }
    }

    private function createResponse(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $code = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
        $headers = $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : [];

        $response = $this->getResponseFactory()->createResponse($code);

        foreach ($headers as $name => $value) {
            $response = $response->withAddedHeader($name, $value);
        }

        $type = $this->resolveContentType($request, $response);

        $settings = $this->getSettings();
        $debug = $settings->has(ExceptionHandlerSettings::DEBUG)
            && $settings->get(ExceptionHandlerSettings::DEBUG);

        $renderer = $this->getExceptionRendererResolver()->resolve($type);

        if (empty($response->getHeader('content-type'))) {
            $mime = $renderer::getMimeTypes()[0];
            $response = $response->withAddedHeader('content-type', $mime);
        }

        $body = $renderer->render($exception, $debug);

        return $response->withBody(Utils::streamFor($body));
    }

    private function resolveContentType(ServerRequestInterface $request, ResponseInterface $response): string
    {
        if (false === empty($response->getHeader('content-type'))) {
            return $response->getHeader('content-type')[0];
        }

        if (false === empty($request->getHeader('accept'))) {
            return $request->getHeader('accept')[0];
        }

        return '*/*';
    }

    private function getExceptionRendererResolver(): ExceptionRendererResolverInterface
    {
        if (null === $this->resolver) {
            $this->resolver = new ExceptionRendererResolver(
                $this->getDefaultRenderer(),
                $this->getRenderers()
            );
        }

        return $this->resolver;
    }

    private function getDefaultRenderer(): string
    {
        $settings = $this->getSettings();

        if ($settings->has(ExceptionHandlerSettings::DEFAULT_RENDERER)) {
            $defaultRenderer = $settings->get(ExceptionHandlerSettings::DEFAULT_RENDERER);

            if (false === is_string($defaultRenderer)) {
                throw new InternalServerErrorException(sprintf(
                    'Settings key "%s" is defined but it doesn\'t return a string.',
                    ExceptionHandlerSettings::DEFAULT_RENDERER
                ));
            }

            return $defaultRenderer;
        }

        return JsonExceptionRenderer::class;
    }

    /**
     * @return array<string>
     */
    private function getRenderers(): array
    {
        $settings = $this->getSettings();

        if ($settings->has(ExceptionHandlerSettings::RENDERERS)) {
            $renderers = $settings->get(ExceptionHandlerSettings::RENDERERS);

            if (false === is_array($renderers)) {
                throw new InternalServerErrorException(sprintf(
                    'Settings key "%s" is defined but it doesn\'t return an array.',
                    ExceptionHandlerSettings::RENDERERS
                ));
            }

            return $renderers;
        }

        return [];
    }
}
