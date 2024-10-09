<?php namespace Flag\Framework\Router;

class Route {
    private mixed $endpoint;
    private string $controller;
    private string $action;
    private array $data;

    public function __construct(string | callable $route, array $data = []) {
        $this->endpoint = $route;
        $this->data = $data;

        if (!$this->isCallable()) {
            $this->parse();
        }
    }

    private function parse(): void {
        [$controller, $action] = explode('::', $this->endpoint);

        $this->controller = $controller;
        $this->action = $action;
    }

    public function isCallable(): bool {
        return is_callable($this->endpoint);
    }

    public function getCallable(): ?callable {
        if ($this->isCallable()) {
            return $this->endpoint;
        }

        return null;
    } 

    public function getController(): string {
        return $this->controller;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function hasData(): bool {
        return count($this->data) > 0;
    }

    public function getData(): array {
        return $this->data;
    }
}