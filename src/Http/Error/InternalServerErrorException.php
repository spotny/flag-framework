<?php namespace Flag\Framework\Http\Error;

class InternalServerErrorException extends HttpException {

    public function __construct(string $message = 'Internal Server Error') {
        parent::__construct($message, 500);
    }
}