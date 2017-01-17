<?php
namespace AppBundle\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

interface ExceptionResponseBuilderInterface
{
    public function init(GetResponseForExceptionEvent $event);
    public function createResponse(): Response;
    public function setException($exception): ExceptionResponseBuilderInterface;
    public function setEvent($event): ExceptionResponseBuilderInterface;
}