<?php namespace Flag\Framework\Http;

class Request {
    
    public static function get(string $key, string $defaultValue = null): ?string {
        return $_GET[$key] ?? $defaultValue;
    }
    
    public static function post(string $key, string $defaultValue = null): ?string {
        return $_POST[$key] ?? $defaultValue;
    }
    
    public static function file(string $key): ?array {
        return isset($_FILES[$key]) ? $_FILES[$key] : null;
    }
    
    public static function session(string $key, mixed $value = null): mixed {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (is_null($value)) {
            return $_SESSION[$key] ?? null;
        }

        $_SESSION[$key] = $value;

        return $value;
    }
    
    public static function cookie(string $key, string $value = null, int $valid = 3600): ?string {
        if (is_null($value)) {
            return $_COOKIE[$key] ?? null;
        }

        setcookie($key, $value, time() + $valid);
        return $value;
    }

    public static function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isAuth() {
        return Request::session('user');
    }
}