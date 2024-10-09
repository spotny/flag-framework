<?php namespace Flag\Framework\Http\Error;

class ForbiddenException extends HttpException {

    public function __construct(string $message = 'Forbidden') {
        parent::__construct($message, 403);
    }
}