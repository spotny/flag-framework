<?php namespace Flag\Framework\Core;

use Flag\Framework\Http\Error\HttpException;
use Flag\Framework\Http\Error\InternalServerErrorException;
use Flag\Framework\Router\Router;
use Flagrow\Framework\Router\Route;
use ReflectionClass;
use ReflectionException;

class Application {

    private string $defaultPath = '/';
    private Router $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function run(): void {
        $path = $this->getPath();

        try {
            $route = $this->router->match($path);
            $this->call($route);
        } catch (HttpException $e) {
            $this->showError($e);
        }
    }

    private function call(Route $route): void {
        if ($route->isCallable()) {
            $action = $route->getCallable();
            $action($route->getData());
        }

        $controller = $route->getController();
        $action = $route->getAction();

        try {
            $reflector = new ReflectionClass($controller);
    
            if (!$reflector->isInstantiable()) {
                throw new InternalServerErrorException();
            }
    
            $instance = $reflector->newInstance();
            $method = $reflector->getMethod($action);
    
            if ($route->hasData()) {
                $method->invokeArgs($instance, $route->getData());
            } else {
                $method->invoke($instance);
            }
        } catch (ReflectionException $e) {
            throw new InternalServerErrorException($e->getMessage());
        }
    }

    private function showError(HttpException $exception): void {
        $code = $exception->getCode();
        $message = $exception->getMessage();

        // TODO: refactor error page
        header("HTTP/1.0 $code $message");
        die("$code => $message");
    }

    public function getPath(): string {
        return $_SERVER['PATH_INFO'] ?? $this->defaultPath;
    }

    public function setDefaultPath(string $defaultPath): self {
        $this->defaultPath = $defaultPath;

        return $this;
    }
}