<?php
namespace AppBundle\Exceptions;

use Exception;

class DefaultException extends Exception
{
    protected $code = 123;
}