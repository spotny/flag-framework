<?php namespace Flag\Framework\Http;

class FlashBag {

    const NAME = 'flash_bag';

    public static function add(string $message, string $type = 'info'): void {
        $bag = Request::session(self::NAME);

        if (is_null($bag)) {
            $bag = [];
        }

        $bag[] = [
            'type' => $type,
            'message' => $message
        ];

        Request::session(self::NAME, $bag);
    }

    public static function has(): bool {
        return Request::session(self::NAME) && count(Request::session(self::NAME)) > 0;
    }

    public static function get(): array {
        $bag = Request::session(self::NAME);
        unset($_SESSION[self::NAME]);

        return $bag ?? [];
    }
}