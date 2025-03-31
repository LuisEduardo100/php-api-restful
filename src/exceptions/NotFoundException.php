<?php

namespace Luise\Apirestful\exceptions;

class NotFoundException extends \Exception
{
  public function __construct(string $message = "Not found", int $code = 404, \Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
