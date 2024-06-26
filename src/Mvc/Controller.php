<?php namespace Flag\Framework\Mvc;

use Flag\Framework\Http\Request;
use Flag\Framework\Http\Response;

abstract class Controller {

    protected function redirect(string $url): void {
        Response::redirect($url);
    }

    protected function render(string $name, array $data = null, bool $layout = true): void {
        View::render($name, $data, $layout);
    }
    
    protected function isPost(): bool {
        return Request::isPost();
    }
    
    protected function isAuth() {
        return Request::isAuth();
    }

    protected function json(mixed $data): void {
        View::json($data);
    }
}