<?php namespace Flag\Framework\Http\Error;

class MethodNotAllowedException extends HttpException {

    public function __construct(string $message = 'Method Not Allowed') {
        parent::__construct($message, 405);
    }
}