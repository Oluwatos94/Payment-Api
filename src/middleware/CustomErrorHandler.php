<?php

namespace PaymentApi\middleware;

use Doctrine\ORM\Exception\ORMException;
use Monolog\Logger;
use paymentApi\Exceptions\A_Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Throwable;

final class CustomErrorHandler
{
    private Logger $logger;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(private readonly App $app)
    {
        $this->logger = $this->app->getContainer()->get(logger::class);
    }

    public function __invoke(
        Request          $request,
        Throwable        $exception,
        bool             $displayErrorDetails,
        bool             $logErrors,
        bool             $logErrorDetails,
        ?LoggerInterface $logger = null
    )
    {
        $logger?->error($exception->getMessage());
        if($exception instanceof ORMException
            || $exception instanceof HttpNotFoundException
            || $exception instanceof \PDOException){

            $this->logger->critical($exception->getMessage());
            $statusCode = 500;
        } else if ($exception instanceof A_Exception){

            $this->logger->alert($exception->getMessage());
            $statusCode = $exception->getCode();
        }
        $payload = [
            'message' => $exception->getMessage()
    ];
        if($displayErrorDetails) {
            $payload['details'] = $exception->getMessage();
            $payload['Trace'] = $exception->getTrace();
        }


        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );

        return $response->withStatus($statusCode);
    }
}