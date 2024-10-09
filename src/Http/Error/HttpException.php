<?php namespace Flag\Framework\Http\Error;
      use Exception;
use Flag\Framework\Http\Response;

abstract class HttpException extends Exception {

    public function __construct(string $message = 'Internal Server Error', int $code = 500) {
        Response::status($code, $message);
        parent::__construct($message, $code);
    }
}