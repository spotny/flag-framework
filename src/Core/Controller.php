<?php namespace Flag\Framework\Core;

abstract class Controller {

    protected function redirect(string $url): void {
        Response::redirect($url);
    }

    protected function render(string $name, array $data = null, bool $layout = true): void {
        Response::render($name, $data, $layout);
    }
    
    protected function isPost(): bool {
        return Request::isPost();
    }
    
    protected function isAuth() {
        return Request::isAuth();
    }

    protected function json(mixed $data): void {
        Response::json($data);
    }
}