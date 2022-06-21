<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Renderer;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\Renderer\HtmlExceptionRenderer;
use Throwable;

final class HtmlExceptionRendererTest extends TestCase
{
    public function testRenderer(): void
    {
        $renderer = new HtmlExceptionRenderer();

        try {
            $exception = new HttpException('Some error', [], [], 666);
            /** @phpstan-ignore-next-line */
        } catch (Throwable $exception) {
            // do nothing
        }

        $html = $renderer->render($exception, true);

        $this->assertSame(['text/html'], HtmlExceptionRenderer::getMimeTypes());
        $this->assertTrue(str_contains($html, '<h2>Some error</h2>'));
    }
}
