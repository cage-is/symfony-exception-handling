<?php
namespace AppBundle\Exceptions;

interface CustomResponseExceptionInterface
{
    public function getExceptionResponseBuilder(): ExceptionResponseBuilderInterface;
}