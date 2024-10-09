<?php namespace Flag\Framework\Mvc;

use Flag\Framework\Http\FlashBag;
use Flag\Framework\Http\Request;
use Flag\Framework\Http\Response;

abstract class Controller {
    
    protected function redirect(string $url, int $code = 301): void {
        Response::redirect($url, $code);
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

    protected function addFlash(string $message, string $type = 'info'): void {
        FlashBag::add($message, $type);
    }
}