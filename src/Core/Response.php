<?php namespace Flag\Framework\Core;

use Exception;

class Response {

    public static function redirect(string $url): void {
        header("Location: $url");
        die();
    }

    public static function render(string $name, array $data = null, bool $layout = true): void {
        $path = "../views/$name.phtml";
    
        if (!file_exists($path)) {
            throw new Exception('Internal Server Error', 500);
        }
    
        if (!is_null($data)) {
            extract($data);
        }

        $helpers = glob('../views/helpers/*.helper.php');

        foreach ($helpers as $helper) {
            require_once $helper;
        }
    
        if ($layout) {
            include "../views/common/header.phtml";
            include $path;
            include "../views/common/footer.phtml";
        } else {
            include $path;
        }
    }

    public static function json(mixed $data): void {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}