<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

interface ExceptionRendererResolverInterface
{
    public function addRenderer(ExceptionRendererInterface|string $renderer): self;
    public function setDefaultRenderer(ExceptionRendererInterface|string $renderer): self;
    public function getDefaultRenderer(): ExceptionRendererInterface;
    public function resolve(string $type): ExceptionRendererInterface;
}
