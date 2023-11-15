<?php

namespace PaymentApi\Controllers;

use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use Monolog\Logger;
use PaymentApi\models\A_model;
use PaymentApi\Repository\A_Repository;
use PaymentApi\Routes;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class A_Controllers
{
     protected A_Repository $repository;
     protected Logger $logger;
     protected Routes $routeEnum;
     protected string $routeValue;
     protected A_model $model;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(protected ContainerInterface $container)
     {
         $this->logger = $this->container->get(Logger::class);
     }

    protected function indexAction(Request $request, Response $response): ResponseInterface
    {
        $records = $this->repository->findAll();

        if (count($records) > 0) {
            return new JsonResponse([
                'type' => '',
                'title' => 'List of ' . $this->routeValue,
                'status' => 200,
                'detail' => $records,
                'instance' => '/v1/ ' . $this->routeValue
            ], 200);
        } else {
            $context = [
                'type' => 'error/no_method_found',
                'title' => 'List of ' . $this->routeValue,
                'status' => 400,
                'detail' => count($records),
                'instance' => '/v1/ ' . $this->routeValue
            ];
            $this->logger->info('No ' . $this->routeValue . ' found', $context);
            return new JsonResponse('$context', 400);
        }
    }

    protected function createAction(Request $request, Response $response): ResponseInterface
    {
        try {
            $this->repository->save($this->model);
        } catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
            return new JsonResponse([
                'type' => 'Internal server error upon creation of new ' . $this->routeEnum->toString(),
                'title' => 'Internal server error',
                'status' => 500,
                'detail' => '',
                'instance' => '/v1/ ' . $this->routeValue . '/createAction'
            ], 500);
        }
        return new JsonResponse([
            'type' => '',
            'title' => 'New ' . $this->routeEnum->toString() . 'Successfully created',
            'status' => 200,
            'detail' => $this->model->getId(),
            'instance' => '/v1/ ' . $this->routeValue . '/createAction'
        ], 200);
    }

    /**
     * @param Request $request
     * @param Response $rsesponse
     * @param array $arg
     * @return Response
     */
    protected function deActivateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $records = $this->repository->findById($args['Id']);
        if(is_null($records)){
            $context = [
                'type' => 'error/no ' . $this->routeEnum->toString() . 'upon deactivation',
                'title' => $this->routeEnum->toString() . 'Deactivated!',
                'status' => 400,
                'detail' => $args['Id'],
                'instance' => '/v1/ ' . $this->routeValue . '/deactivate/{Id}'
            ];
            $this->logger->info('No ' . $this->routeValue . ' found', $context);
            return new JsonResponse('$context', 400);
        }
        $records->setIsActive(false);
        try {
            $this->repository->update($records);
        } catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
            return new JsonResponse([
                'type' => 'Internal server error upon deactivation' . $this->routeEnum->toString(),
                'title' => 'Internal server error',
                'status' => 500,
                'detail' => $records,
                'instance' => '/v1/ ' . $this->routeValue . '/deactivate/{Id}'
            ], 500);
        }
        return new JsonResponse([
            'type' => '',
            'title' => $this->routeEnum->toString() . 'Successfully deactivated',
            'status' => 200,
            'detail' => $records,
            'instance' => '/v1/ ' . $this->routeValue . '/deactivate/{Id}'
        ], 200);
    }

    protected function reActivateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $records = $this->repository->findById($args['Id']);
        if(is_null($records)){
            $context = [
                'type' => 'error/no ' . $this->routeEnum->toString() . 'upon reactivation',
                'title' => $this->routeEnum->toString() . 'Reactivated!',
                'status' => 400,
                'detail' => $args['Id'],
                'instance' => '/v1/ ' . $this->routeValue . '/reactivate/{Id}'
            ];
            $this->logger->info('No ' . $this->routeEnum->toString() . ' found', $context);
            return new JsonResponse('$context', 400);
        }
        $records->setIsActive(false);
        try {
            $this->repository->update($records);
        } catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
            return new JsonResponse([
                'type' => 'Internal server error upon reactivation' . $this->routeEnum->toString(),
                'title' => 'Internal server error',
                'status' => 500,
                'detail' => '',
                'instance' => '/v1/ ' . $this->routeValue . '/reactivate/{Id}'
            ], 500);
        }
        return new JsonResponse([
            'type' => '',
            'title' => $this->routeEnum->toString() . 'Successfully reactivated',
            'status' => 200,
            'detail' => $records,
            'instance' => '/v1/ ' . $this->routeValue . '/reactivate/{Id}'
        ], 200);
    }

    protected function removeAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $records = $this->repository->findbyId($args['Id']);
        if(is_null($records)){
            $context = [
                'type' => 'error/no ' . $this->routeValue . ' to be removed',
                'title' => 'Removing ' . $this->routeEnum->toString(),
                'status' => 400,
                'detail' => $args['Id'],
                'instance' => '/v1/ ' . $this->routeValue . '/removeAction/{Id}'
            ];
            $this->logger->info('No ' . $this->routeEnum->toString() . ' found', $context);
            return new JsonResponse('$context', 400);
        }
        try {
            $this->repository->remove($records);
        } catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
            return new JsonResponse([
                'type' => 'Internal server error upon removing' . $this->routeEnum->toString(),
                'title' => 'Internal server error',
                'status' => 500,
                'detail' => '',
                'instance' => '/v1/ ' . $this->routeValue . '/removeAction/{Id}'
            ], 500);
        }
        return new JsonResponse([
            'type' => '',
            'title' => $this->routeEnum->toString() . 'Successfully removed',
            'status' => 200,
            'detail' => $records,
            'instance' => '/v1/ ' . $this->routeValue . '/removeAction/{Id}'
        ], 200);
    }

    protected function updateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $this->repository->save($this->model);
        } catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
            return new JsonResponse([
                'type' => 'Internal server error upon updating of new ' . $this->routeValue,
                'title' => 'Internal server error',
                'status' => 500,
                'detail' => '',
                'instance' => '/v1/ ' . $this->routeValue . '/{Id}'
            ], 500);
        }
        return new JsonResponse([
            'type' => '',
            'title' => $this->routeEnum->toString() . 'Successfully updated',
            'status' => 200,
            'detail' => '',
            'instance' => '/v1/ ' . $this->routeValue . '/{Id}'
        ], 200);
    }
}