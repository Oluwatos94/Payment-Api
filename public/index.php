<?php

use Slim\Factory\AppFactory;
use PaymentApi\middleware\CustomErrorHandler;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../container/Container.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/Payment-Api/");
$dotenv->safeLoad();

$app = AppFactory::createFromContainer(container: $container);

// Methods
$app->group('/v1/methods', function (RouteCollectorProxy $group){
    $group->get('', '\PaymentApi\Controllers\MethodController:indexAction');
    $group->post('', '\PaymentApi\Controllers\MethodController:createAction');
    $group->delete('/{id:[0-9]+}', '\PaymentApi\Controllers\MethodController:removeAction');
    $group->put('/{id:[0-9]+}', '\PaymentApi\Controllers\MethodController:updateAction');
    $group->get('/deactivate/{id:[0-9]+}', '\PaymentApi\Controllers\MethodController:deActivateAction');
    $group->get('/reactivate/{id:[0-9]+}', '\PaymentApi\Controllers\MethodController:reActivateAction');
});

//Customers
$app->group('/v1/customers', function (RouteCollectorProxy $group) {
    $group->get('', '\PaymentApi\Controllers\CustomersController:indexAction');
    $group->post('', '\PaymentApi\Controllers\CustomersController:createAction');
    $group->delete('/{id:[0-9]+}', '\PaymentApi\Controllers\CustomersController:removeAction');
    $group->put('/{id:[0-9]+}', '\PaymentApi\Controllers\CustomersController:updateAction');
    $group->get('/deactivate/{id:[0-9]+}', '\PaymentApi\Controllers\CustomersController:deActivateAction');
    $group->get('/reactivate/{id:[0-9]+}', '\PaymentApi\Controllers\CustomersController:reActivateAction');
});

// Payment
$app->group('/v1/payments', function (RouteCollectorProxy $group) {
    $group->get('', '\PaymentApi\Controllers\PaymentsController:indexAction');
    $group->post('', '\PaymentApi\Controllers\PaymentsController:createAction');
    $group->delete('/{id:[0-9]+}', '\PaymentApi\Controllers\PaymentsController:removeAction');
    $group->put('/{id:[0-9]+}', '\PaymentApi\Controllers\PaymentsController:updateAction');
    $group->get('/deactivate/{id:[0-9]+}', '\PaymentApi\Controllers\PaymentsController:deactivateAction');
    $group->get('/reactivate/{id:[0-9]+}', '\PaymentApi\Controllers\PaymentsController:reactivateAction');
});

$displayErrors = $_ENV['APP_ENV'] != 'production';
//$displayErrors = false;
$customErrorHandler = new CustomErrorHandler($app);

$errorMiddleware = $app->addErrorMiddleware($displayErrors, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();