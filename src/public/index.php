<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use paymentApi\middleware\CustomErrorHandler;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/paymentApi/");
$dotenv->safeLoad();

$app = AppFactory::create();

// Methods
$app->group('/v1/methods', function (RouteCollectorProxy $group){
    $group->get('', '\PaymentApi\Controllers\MethodController:indexAction');
    $group->post('', '\PaymentApi\Controller\CustomersController:createAction');
    $group->delete('/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:removeAction');
    $group->put('/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:updateAction');
    $group->get('/deactivate/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:deactivateAction');
    $group->get('/reactivate/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:reactivateAction');
});

//Customers
$app->group('/v1/customers', function (RouteCollectorProxy $group) {
    $group->get('', '\PaymentApi\Controller\CustomersController:indexAction');
    $group->post('', '\PaymentApi\Controller\CustomersController:createAction');
    $group->delete('/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:removeAction');
    $group->put('/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:updateAction');
    $group->get('/deactivate/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:deactivateAction');
    $group->get('/reactivate/{id:[0-9]+}', '\PaymentApi\Controller\CustomersController:reactivateAction');
});


$displayErrors = $_ENV['APP_ENV'] != 'production';
//$displayErrors = false;
$customErrorHandler = new CustomErrorHandler($app);

$errorMiddleware = $app->addErrorMiddleware($displayErrors, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();