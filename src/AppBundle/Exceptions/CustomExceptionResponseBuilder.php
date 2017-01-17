<?php
namespace AppBundle\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CustomExceptionResponseBuilder extends ExceptionResponseBuilder implements ExceptionResponseBuilderInterface
{
    public function createResponse(): Response
    {
        $response = new Response;
        $response->setContent($this->getException()->getMessage() . " chicken");

        return $response;

    }
}