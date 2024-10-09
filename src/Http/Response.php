<?php namespace Flag\Framework\Http;

use Exception;

class Response {

    public static function redirect(string $url, int $code = 301): void {
        header("Location: $url", true, $code);
        die();
    }

    public static function header(string $name, string $value, bool $replace = true, int $code = 0): void {
        header("$name: $value", $replace, $code);
    }

    public static function contentType(string $type): void {
        self::header('Content-Type', $type);
    }

    public static function status(int $code, string $message): void {
        self::header("HTTP/1.1 $code $message", '');
    }

    public static function created(): void {
        static::status(201, 'Created');
    }

    public static function noContent(): void {
        static::status(204, 'No Content');
    }

    public static function badRequest(): void {
        static::status(400, 'Bad Request');
    }

    public static function unauthorized(): void {
        static::status(401, 'Unauthorized');
    }

    public static function forbidden(): void {
        static::status(403, 'Forbidden');
    }

    public static function notFound(): void {
        static::status(404, 'Not Found');
    }

    public static function methodNotAllowed(): void {
        static::status(405, 'Method Not Allowed');
    }

    public static function internalServerError(): void {
        static::status(500, 'Internal Server Error');
    }
}