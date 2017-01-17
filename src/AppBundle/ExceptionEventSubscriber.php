<?php
namespace AppBundle;

use Exception;
use AppBundle\Exceptions\ExceptionResponseBuilder;
use AppBundle\Exceptions\CustomResponseExceptionInterface;
use AppBundle\Exceptions\ExceptionResponseBuilderInterface;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionEventSubscriber
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        /** @var ExceptionResponseBuilderInterface $responseBuilder */
        $responseBuilder = $this->getExceptionResponseBuilder($event->getException());
        $responseBuilder->init($event);

        $event->setResponse(
            $responseBuilder->createResponse()
        );
    }

    protected function getExceptionResponseBuilder(Exception $exception): ExceptionResponseBuilderInterface
    {
        if ($exception instanceof CustomResponseExceptionInterface) {
            return $exception->getExceptionResponseBuilder();
        }
        return new ExceptionResponseBuilder;
    }


}