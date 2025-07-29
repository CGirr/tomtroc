<?php

class FormException extends Exception
{
    private array $formData;

    public function __construct(string $message, array $formData = [], int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->formData = $formData;
    }

    public function getFormData(): array {
        return $this->formData;
    }
}