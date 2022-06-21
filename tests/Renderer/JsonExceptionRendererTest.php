<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Renderer;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\HttpException;
use Thingston\Http\Exception\Renderer\JsonExceptionRenderer;
use Throwable;

final class JsonExceptionRendererTest extends TestCase
{
    public function testRenderer(): void
    {
        $renderer = new JsonExceptionRenderer();

        try {
            $exception = new HttpException('Some error', [], [], 666);
            /** @phpstan-ignore-next-line */
        } catch (Throwable $exception) {
            // do nothing
        }

        $json = $renderer->render($exception, true);

        $this->assertSame(['application/json'], JsonExceptionRenderer::getMimeTypes());
        $this->assertTrue(str_contains($json, '"Some error"'));
    }
}
