<?php

namespace Luise\Apirestful\exceptions;

class ValidationException extends \Exception
{
  public function __construct($message)
  {
    parent::__construct($message, 500);
  }
}
