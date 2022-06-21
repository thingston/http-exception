<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Renderer;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\Renderer\XmlExceptionRenderer;
use Throwable;

final class XmlExceptionRendererTest extends TestCase
{
    public function testRenderer(): void
    {
        $renderer = new XmlExceptionRenderer();

        try {
            $exception = new HttpException('Some error', [], [], 666);
            /** @phpstan-ignore-next-line */
        } catch (Throwable $exception) {
            // do nothing
        }

        $xml = $renderer->render($exception, true);

        $this->assertSame(['text/xml'], XmlExceptionRenderer::getMimeTypes());
        $this->assertTrue(str_contains($xml, '<message>Some error</message>'));
    }
}
