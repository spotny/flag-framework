<?php namespace Flag\Framework\Core;

use Exception;

class Router {

    private array $routes;

    public function __construct() {
        if (file_exists('../config/routes.php')) {
            $this->routes = require '../config/routes.php';
        } else {
            $this->routes = [];
        }
    }

    public function add(array $route): self {
        $this->routes[] = $route;
        return $this;
    }

    public function getActive(string $path): array {
        if (!isset($this->routes[$path])) {
            throw new Exception('Not Found', 404);
        }

        return $this->routes[$path];
    }
}