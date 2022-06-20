<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Renderer;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\Renderer\PlainTextExceptionRenderer;
use Throwable;

final class PlainTextExceptionRendererTest extends TestCase
{
    public function testRenderer(): void
    {
        $renderer = new PlainTextExceptionRenderer();

        try {
            $exception = new HttpException('Some error', [], [], 666);
            /** @phpstan-ignore-next-line */
        } catch (Throwable $exception) {
            // do nothing
        }

        $text = $renderer->render($exception, true);

        $this->assertSame(['text/plain'], PlainTextExceptionRenderer::getMimeTypes());
        $this->assertTrue(str_contains($text, 'Some error'));
    }
}
