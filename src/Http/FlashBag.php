<?php namespace Flag\Framework\Http;

class FlashBag {

    private static string $name = 'flash_bag';

    public static function add(string $message, string $type = 'info'): void {
        $bag = Request::session(self::$name);

        if (is_null($bag)) {
            $bag = [];
        }

        $bag[] = [
            'type' => $type,
            'message' => $message
        ];

        Request::session(self::$name, $bag);
    }

    public static function has(): bool {
        return Request::session(self::$name) && count(Request::session(self::$name)) > 0;
    }

    public function get(): array {
        $bag = Request::session(self::$name);
        Request::session(self::$name, []);

        return $bag;
    }
}