<?php
declare(strict_types=1);

namespace PaymentApiTests;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
use Mockery;
use Monolog\Logger;
use PaymentApi\Controllers\MethodController;
use PaymentApi\Repository\MethodsRepository;
use PaymentApi\Repository\MethodsRepositoryDoctrine;
use PHPUnit\Framework\TestCase;

class MethodsControllerTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $container = new Container();
        $container->set(EntityManager::class, function (Container $c) {
            return Mockery::mock("Doctrine\\ORM\\EntityManager");
        });

        $container->set(MethodsRepository::class, function(Container $c) {
            $em = $c->get(EntityManager::class);
            return new MethodsRepositoryDoctrine($em);
        });

        $container->set(Logger::class, function (Container $c) {
            return Mockery::mock("Monolog\logger");
        });

        $this->container = $container;

    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function testCreateInstanceOfMethodsController()
    {
        $abstractControllersMethods = new MethodController($this->container);
        $this->assertInstanceOf("PaymentApi\Controllers\MethodController", $abstractControllersMethods);
    }
}