<?php namespace Flag\Framework\Http\Error;

class UnauthorizedException extends HttpException {

    public function __construct(string $message = 'Unauthorized') {
        parent::__construct($message, 401);
    }
}