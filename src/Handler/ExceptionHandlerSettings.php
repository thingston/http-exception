<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Handler;

use Thingston\Http\Exception\Renderer\HtmlExceptionRenderer;
use Thingston\Http\Exception\Renderer\JsonExceptionRenderer;
use Thingston\Http\Exception\Renderer\PlainTextExceptionRenderer;
use Thingston\Http\Exception\Renderer\XmlExceptionRenderer;
use Thingston\Settings\AbstractSettings;

final class ExceptionHandlerSettings extends AbstractSettings
{
    public const DEBUG = 'debug';
    public const LOG_ERRORS = 'logErrors';
    public const LOG_DETAILS = 'logDetails';
    public const DEFAULT_RENDERER = 'defaultRenderer';
    public const RENDERERS = 'renderers';

    /**
     * @param array<string, array<mixed>|scalar|\Thingston\Settings\SettingsInterface> $settings
     */
    public function __construct(array $settings = [])
    {
        parent::__construct([
            self::DEBUG => (bool) ($settings[self::DEBUG] ?? false),
            self::LOG_ERRORS => (bool) ($settings[self::LOG_ERRORS] ?? true),
            self::LOG_DETAILS => (bool) ($settings[self::LOG_DETAILS] ?? false),
            self::DEFAULT_RENDERER => JsonExceptionRenderer::class,
            self::RENDERERS => [
                HtmlExceptionRenderer::class,
                JsonExceptionRenderer::class,
                XmlExceptionRenderer::class,
                PlainTextExceptionRenderer::class,
            ],
        ]);
    }
}
