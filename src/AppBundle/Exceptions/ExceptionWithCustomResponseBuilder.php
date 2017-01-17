<?php
namespace AppBundle\Exceptions;

use Exception;

class ExceptionWithCustomResponseBuilder extends Exception implements CustomResponseExceptionInterface
{

    public function getExceptionResponseBuilder(): ExceptionResponseBuilderInterface
    {
        return new CustomExceptionResponseBuilder;
    }
}