<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Renderer;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\HttpExceptionInterface;
use Thingston\Http\Exception\Renderer\ExceptionRendererResolver;
use Thingston\Http\Exception\Renderer\HtmlExceptionRenderer;
use Thingston\Http\Exception\Renderer\JsonExceptionRenderer;
use Thingston\Http\Exception\Renderer\PlainTextExceptionRenderer;

final class ExceptionRendererResolverTest extends TestCase
{
    public function testDefaultExceptionRenderer(): void
    {
        $resolver = new ExceptionRendererResolver(HtmlExceptionRenderer::class);

        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->getDefaultRenderer());
        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->resolve('text/html'));
        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->resolve('application/json'));
        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->resolve('text/xml'));

        $renderer = new PlainTextExceptionRenderer();
        $resolver->setDefaultRenderer($renderer);

        $this->assertSame($renderer, $resolver->getDefaultRenderer());
        $this->assertSame($renderer, $resolver->resolve('foo/bar'));
    }

    public function testResolveRenderer(): void
    {
        $resolver = new ExceptionRendererResolver(HtmlExceptionRenderer::class, [
            new HtmlExceptionRenderer(),
            JsonExceptionRenderer::class,
        ]);

        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->getDefaultRenderer());
        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->resolve('text/html'));
        $this->assertInstanceOf(JsonExceptionRenderer::class, $resolver->resolve('application/json'));
        $this->assertInstanceOf(HtmlExceptionRenderer::class, $resolver->resolve('text/xml'));
    }

    public function testInvalidRenderer(): void
    {
        $resolver = new ExceptionRendererResolver(HtmlExceptionRenderer::class);

        $this->expectException(HttpExceptionInterface::class);
        $resolver->addRenderer('foo');
    }
}
