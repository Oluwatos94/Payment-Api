<?php

namespace PaymentApi\Controllers;

use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use PaymentApi\models\Methods;
use PaymentApi\Routes;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PaymentApi\Repository\MethodsRepository;

final class MethodController extends A_Controllers
{
    private MethodsRepository $MethodsRepository;


    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(ContainerInterface $container)
    {
        Parent::__construct($container);
        $this->routeEnum = Routes::Methods;
        $this->routeValue = Routes::Methods->value;
        $this->repository = $this->container->get(MethodsRepository::class);
    }

    /**
     * @OA\Get(
     *       path="/v1/methodss",
     *       description="Returns all payment methods",
     *       @OA\Response(
     *            response=200,
     *            description="payment methods response",
     *        ),
     *        @OA\Response(
     *            response=500,
     *            description="Internal server error",
     *        ),
     *     )
     *   )
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
     *      path="/v1/methods",
     *      description="Creates a payment method",
     *      @OA\RequestBody(
     *           description="Input data format",
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   type="object",
     *                   @OA\Property(
     *                       property="name",
     *                       description="name of new payment method",
     *                       type="string",
     *                   ),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *           response=200,
     *           description="payment method has been created successfully",
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
        $method = new Methods();
        $method->setName($name);
        $method->setIsActive(true);

        return parent::createAction($request, $response);
    }

    /**
     * @OA\Put(
     *      path="/v1/methods/{id}",
     *      description="update a single payment method based on method's ID",
     *      @OA\Parameter(
     *           description="ID of a payment method to update",
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
     *                        description="name of payment method",
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

        $method = $this->repository->findById($args['Id']);
        if(is_null($method)){

            $context = [
                'type' => 'error/no_method_found_upon_update',
                'title' => 'List of customers',
                'status' => 400,
                'detail' => $args['Id'],
                'instance' => '/v1/methods/{Id} '
            ];
            $this->logger->info('No  methods found', $context);
            return new JsonResponse('$context', 400);
        }
        $this->model = $method;
        $this->model->setName($name);

        return parent::updateAction($request, $response, $args);
    }

    /**
     * @OA\Get(
     *       path="/v1/Methods/deactivate/{id}",
     *       description="Deactivates a single payment method based on method's ID",
     *       @OA\Parameter(
     *            description="ID of a method to update",
     *            in="path",
     *            name="id",
     *            required=true,
     *            @OA\Schema(
     *                format="int64",
     *                type="integer"
     *            )
     *        ),
     *   @OA\Response(
     *             response=200,
     *             description="Payment method has been deactivated successfully",
     *         ),
     *   @OA\Response(
     *             response=400,
     *             description="bad request",
     *         ),
     *       @OA\Response(
     *                  response=404,
     *              description="Payment method not found",
     *          ),
     *       @OA\Response(
     *              response=500,
     *              description="Internal server error",
     *          ),
     *    )
     * @param Request $request
     * @param Response $response
     * @param array $arg
     * @return Response
     */
    public function deActivateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        return parent::deActivateAction($request, $response, $args[]);
    }

    /**
     * @OA\Get(
     *      path="/v1/methods/reactivate/{id}",
     *      description="Reactivates a single payment method based on method's ID",
     *      @OA\Parameter(
     *           description="ID of a payment method to update",
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
     *            description="Payment method has been reactivated successfully",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="Paymenet method not found",
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
     * @OA\Delete(
     *      path="/v1/methods/{id}",
     *      description="deletes a single payment method based on method's ID",
     *      @OA\Parameter(
     *          description="ID of method to be deleted",
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
     *          description="payment has been successfully deleted"
     *      ),
     *  @OA\Response(
     *             response=400,
     *             description="bad request",
     *         ),
     *  @OA\Response(
     *                  response=404,
     *              description="Payment method not found",
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
}