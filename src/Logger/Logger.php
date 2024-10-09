<?php namespace Flag\Framework\Logger;
      use DateTime;

class Logger {

    public static function info(bool $persist = false, string ...$messages): void {
        $now = new DateTime();

        foreach ($messages as $message) {
            $log = sprintf("i/%s from %s", $message, $_SERVER['REMOTE_ADDR']);
            error_log($log);

            if ($persist) {
                file_put_contents('../logs/app.log', sprintf("i/[%s] %s from %s\n", $now->format('Y-m-d H:i:s'), $message, $_SERVER['REMOTE_ADDR']), FILE_APPEND);            
            }
        }
    }
}