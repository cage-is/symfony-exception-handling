<?php
namespace AppBundle\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionResponseBuilder implements ExceptionResponseBuilderInterface
{
    /**
     * @var Exception
     */
    private $exception;

    /**
     * @var GetResponseForExceptionEvent
     */
    private $event;

    /**
     * @var bool
     */
    private $isAjax;

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function init(GetResponseForExceptionEvent $event)
    {
        $this
            ->setException($event->getException())
            ->setEvent($event);
    }

    /**
     * Given the dependencies setup in init.
     * @return Response
     */
    public function createResponse(): Response
    {
        /** @var Response $response */
        $response = $this->isAjax() ? $this->getAjaxExceptionResponse() : $this->getExceptionResponse();

        if ($this->getException() instanceof HttpExceptionInterface) {
            $response->headers->replace($this->getException()->getHeaders());
        }

        return $response;
    }

    /**
     * @return JsonResponse
     */
    protected function getAjaxExceptionResponse()
    {
        $exception = $this->getException();
        return new JsonResponse([
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ]);
    }

    /**
     * @return Response
     */
    protected function getExceptionResponse()
    {
        $exception = $this->getException();
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        return new Response(
            $message,
            $this->getStatusCode()
        );
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        if (is_null($this->isAjax)) {
            $this->isAjax = (bool) $this->getEvent()->getRequest()->isXmlHttpRequest();
        }

        return $this->isAjax;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        $exception = $this->getException();
        return $this->isAjax() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @return Exception
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     * @return ExceptionResponseBuilderInterface
     */
    public function setException($exception): ExceptionResponseBuilderInterface
    {
        $this->exception = $exception;
        return $this;
    }

    /**
     * @return GetResponseForExceptionEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param $event
     * @return ExceptionResponseBuilderInterface
     */
    public function setEvent($event): ExceptionResponseBuilderInterface
    {
        $this->event = $event;
        return $this;
    }
}