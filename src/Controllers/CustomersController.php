<?php

namespace PaymentApi\Controllers;

use Laminas\Diactoros\Response\JsonResponse;
use PaymentApi\Repository\CustomersRepository;
use PaymentApi\Routes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use PaymentApi\models\Customers;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class CustomersController extends A_Controllers
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->routeEnum = Routes::Customers;
        $this->routeValue = Routes::Customers->value;
        $this->repository = $container->get(CustomersRepository::Class);
    }

    /**
     * @OA\Get(
     *      path="/v1/customers",
     *      description="Returns all customers",
     *      @OA\Response(
     *           response=200,
     *           description="customers response",
     *       ),
     *       @OA\Response(
     *           response=500,
     *           description="Internal server error",
     *       ),
     *    )
     *  )
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function indexAction(Request $request, Response $response): ResponseInterface
    {
        return parent::indexAction($request, $response);
    }
    /**
     * @OA\Post(
     *      path="/v1/customers",
     *      description="Creates a new customer",
     *      @OA\RequestBody(
     *           description="Input data format",
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   type="object",
     *                   @OA\Property(
     *                       property="name",
     *                       description="name of new customer",
     *                       type="string",
     *                   ),
     *                    @OA\Property(
     *                        property="Email",
     *                        description="Email of the customer",
     *                        type="string",
     *                   ),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *           response=200,
     *           description="A new customer has been created successfully",
     *       ),
     *      @OA\Response(
     *           response=400,
     *           description="bad request",
     *       ),
     *       @OA\Response(
     *             response=500,
     *             description="Internal server error",
     *         ),
     *    ),
     *  )
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function createAction(Request $request, Response $response): ResponseInterface
    {
        $responseBody = Json_decode($request->getBody()->getContents(), true);
        $name = filter_var($responseBody['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($responseBody['email'], FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_SPECIAL_CHARS);

        $this->model = new customers();
        $this->model->setName($name);
        $this->model->setIsActive(true);
        $this->model->setEmail($email);

        return parent::createAction($request, $response);
    }

    /**
     * @OA\Put(
     *      path="/v1/customers/{id}",
     *      description="update a single customer based on customer's ID",
     *      @OA\Parameter(
     *           description="ID of a customer to update",
     *           in="path",
     *           name="id",
     *           required=true,
     *           @OA\Schema(
     *               format="int64",
     *               type="integer"
     *           )
     *       ),
     *      @OA\RequestBody(
     *            description="Input data format",
     *            @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(
     *                    type="object",
     *                    @OA\Property(
     *                        property="name",
     *                        description="name of customer",
     *                        type="string",
     *                    ),
     *                   @OA\Property(
     *                        property="email",
     *                        description="email of customer",
     *                        type="string",
     *                    ),
     *                ),
     *            ),
     *        ),
     *  @OA\Response(
     *            response=200,
     *            description="customer has been created successfully",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="customer not found",
     *         ),
     *      @OA\Response(
     *             response=500,
     *             description="Internal server error",
     *         ),
     *   )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function updateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $requestBody = Json_decode($request->getBody()->getContents(), true);
        $name = filter_var($requestBody['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($requestBody['email'], FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_SPECIAL_CHARS);

        $customer = $this->repository->findById($args['id']);
        if(is_null($customer)){

            $context = [
                'type' => 'error/no_customer_found_upon_update',
                'title' => 'List of customers',
                'status' => 400,
                'detail' => $args['id'],
                'instance' => '/v1/customer/{id} '
            ];
            $this->logger->info('No  customers found', $context);
            return new JsonResponse('$context', 400);
        }
        $this->model = $customer;
        $customer->setName($name);
        $customer->setEmail($email);

        return parent::updateAction($request, $response, $args);
    }

    /**
     * @OA\Delete(
     *      path="/v1/customers/{id}",
     *      description="deletes a single customer based on customer's ID",
     *      @OA\Parameter(
     *          description="ID of customer to be deleted",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              format="int64",
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="customer has been deleted"
     *      ),
     *  @OA\Response(
     *             response=400,
     *             description="bad request",
     *         ),
     *  @OA\Response(
     *                  response=404,
     *              description="Customer not found",
     *          ),
     *  @OA\Response(
     *              response=500,
     *              description="Internal server error",
     *          ),
     *    )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function removeAction(Request $request, Response $response, array $args): ResponseInterface
    {
        return parent::removeAction($request, $response, $args);
    }

    /**
     * @OA\Get(
     *      path="/v1/customers/reactivate/{id}",
     *      description="Reactivates a single customer based on customer's ID",
     *      @OA\Parameter(
     *           description="ID of a customer to update",
     *           in="path",
     *           name="id",
     *           required=true,
     *           @OA\Schema(
     *               format="int64",
     *               type="integer"
     *           )
     *       ),
     *  @OA\Response(
     *            response=200,
     *            description="Customer has been reactivated successfully",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="Customer not found",
     *         ),
     *      @OA\Response(
     *             response=500,
     *             description="Internal server error",
     *         ),
     *   )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function reActivateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        return parent::reActivateAction($request, $response, $args);
    }

    /**
     * @OA\Get(
     *      path="/v1/customers/deactivate/{id}",
     *      description="Deactivates a single customer based on customer's ID",
     *      @OA\Parameter(
     *           description="ID of a customer to update",
     *           in="path",
     *           name="id",
     *           required=true,
     *           @OA\Schema(
     *               format="int64",
     *               type="integer"
     *           )
     *       ),
     *  @OA\Response(
     *            response=200,
     *            description="Customer has been deactivated successfully",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="Customer not found",
     *         ),
     *      @OA\Response(
     *             response=500,
     *             description="Internal server error",
     *         ),
     *   )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function deActivateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        return parent::deActivateAction($request, $response, $args);
    }
}