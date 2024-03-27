<?php namespace Flag\Framework\Http\Error;

class NotFoundException extends HttpException {
    public function __construct(string $message = 'Not Found') {
        parent::__construct($message, 404);
    }
}