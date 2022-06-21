<?php

declare(strict_types=1);

namespace Thingston\Http\Exception\Renderer;

use Thingston\Http\Exception\InternalServerErrorException;

class ExceptionRendererResolver implements ExceptionRendererResolverInterface
{
    /**
     * @var array<string, string>
     */
    private array $renderers = [];

    /**
     * @var array<string, ExceptionRendererInterface>
     */
    private array $instances = [];

    /**
     * @param ExceptionRendererInterface|string $defaultRenderer
     * @param array<ExceptionRendererInterface|string> $renderers
     */
    public function __construct(
        private ExceptionRendererInterface|string $defaultRenderer,
        array $renderers = []
    ) {
        $this->setDefaultRenderer($defaultRenderer);

        foreach ($renderers as $renderer) {
            $this->addRenderer($renderer);
        }
    }

    public function addRenderer(ExceptionRendererInterface|string $renderer): self
    {
        if (is_string($renderer) && false === is_a($renderer, ExceptionRendererInterface::class, true)) {
            throw new InternalServerErrorException(sprintf(
                'Renderer must be an instance of "%s" or their class name.',
                ExceptionRendererInterface::class
            ));
        }

        if ($renderer instanceof ExceptionRendererInterface) {
            $class = get_class($renderer);
            $this->instances[$class] = $renderer;
            $renderer = $class;
        }

        foreach ($renderer::getMimeTypes() as $type) {
            $this->renderers[$type] = $renderer;
        }

        return $this;
    }

    public function setDefaultRenderer(ExceptionRendererInterface|string $renderer): self
    {
        $this->addRenderer($renderer);
        $this->defaultRenderer = $renderer;

        return $this;
    }

    public function getDefaultRenderer(): ExceptionRendererInterface
    {
        $renderer = $this->defaultRenderer;

        if (false === $renderer instanceof ExceptionRendererInterface) {
            if (isset($this->instancess[$renderer])) {
                return $this->defaultRenderer = $this->instancess[$renderer];
            }

            /** @var ExceptionRendererInterface $instance */
            $instance = new $renderer();

            return $this->instances[$renderer] = $this->defaultRenderer = $instance;
        }

        return $renderer;
    }

    public function resolve(string $type): ExceptionRendererInterface
    {
        if (false === isset($this->renderers[$type])) {
            return $this->getDefaultRenderer();
        }

        $renderer = $this->renderers[$type];

        if (false === isset($this->instances[$renderer])) {
            /** @var ExceptionRendererInterface $instance */
            $instance = new $renderer();
            $this->instances[$renderer] = $instance;
        }

        return $this->instances[$renderer];
    }
}
