<?php namespace Flag\Framework\Http\Error;

class BadRequestException extends HttpException {

    public function __construct(string $message = 'Bad Request') {
        parent::__construct($message, 400);
    }
}