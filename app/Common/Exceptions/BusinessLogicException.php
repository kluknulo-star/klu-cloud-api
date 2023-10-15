<?php

namespace App\Common\Exceptions;

use RuntimeException;

class BusinessLogicException extends RuntimeException
{
    protected array $errors = [];

    protected string $field = '';

    protected $code = 422;

    public static function withMessage(string $message, $errors = []): BusinessLogicException
    {
        $exception = new static($message);
        $exception->errors = $errors;

        return $exception;
    }

    public function getErrors(): array
    {
        if ($this->errors) {
            return $this->errors;
        }

        if ($this->field) {
            return [$this->field => $this->message];
        }

        return [];
    }
}