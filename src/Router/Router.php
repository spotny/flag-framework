<?php namespace Flag\Framework\Router;
      use Exception;
use Flag\Framework\Http\Error\NotFoundException;
use Flagrow\Framework\Router\Route;

class Router {
    
    private array $routes = [];

    public function __construct() {
        if (file_exists('../config/routes.php')) {
            $this->routes = require '../config/routes.php';
        }
    }

    public function add(string $endpoint, Route | callable $route): self {
        if (!isset($this->routes[$endpoint])) {
            $this->routes[$endpoint] = is_callable($route) ? $route : sprintf('%s::%s', $route->getController(), $route->getAction());
        }

        return $this;
    }

    public function match(string $path): Route {
        if (strpos($path, ':') === false && isset($this->routes[$path])) {
            return new Route($this->routes[$path]);
        }

        $segments = explode('/', $path);
        $segmentsCount = count($segments);
        $routeData = [];

        foreach ($this->routes as $key => $value) {
            $routeSegments = explode('/', $key);

            if (count($routeSegments) !== $segmentsCount) {
                continue;
            }

            $match = true;

            for ($i = 0; $i < $segmentsCount; $i++) {
                if (isset($routeSegments[$i][0]) && $routeSegments[$i][0] === ':') {
                    $routeData[substr($routeSegments[$i],1)] = $segments[$i];
                    continue;
                }

                if ($segments[$i] !== $routeSegments[$i]) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                return new Route($value, $routeData);
            }
        }

        throw new NotFoundException();
    }
}