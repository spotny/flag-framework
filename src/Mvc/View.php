<?php namespace Flag\Framework\Mvc;

use Flag\Framework\Http\Error\InternalServerErrorException;
use Flag\Framework\Http\Response;

class View {
    public static function render(string $name, array $data = null, bool $layout = true): void {
        $path = "../views/$name.phtml";

        if (!file_exists($path)) {
            throw new InternalServerErrorException();
        }

        if (!is_null($data)) {
            extract($data);
        }

        $helpers = glob('../views/helpers/*.helper.php');

        foreach ($helpers as $helper) {
            require_once $helper;
        }

        if ($layout) {
            self::render('common/header', $data, false);
            include $path;
            self::render('common/footer', $data, false);
        } else {
            include $path;
        }
    }

    public static function json(mixed $data): void {
        Response::contentType('application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}