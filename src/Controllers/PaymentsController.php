<?php

namespace PaymentApi\Controllers;

use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use PaymentApi\models\Payments;
use PaymentApi\Repository\PaymentsRepository;
use PaymentApi\Routes;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PaymentsController extends A_Controllers
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(ContainerInterface $container)
    {
        Parent::__construct($container);
        $this->routeEnum = Routes::Payments;
        $this->routeValue = Routes::Payments->value;
        $this->repository = $this->container->get(PaymentsRepository::class);
    }

    /**
     * @OA\Get(
     *       path="/v1/Payments",
     *       description="Returns all payments",
     *       @OA\Response(
     *            response=200,
     *            description="payment response",
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
     *      path="/v1/payments",
     *      description="Creates a payment",
     *      @OA\RequestBody(
     *           description="Input data format",
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   type="object",
     *                   @OA\Property(
     *                       property="customer_id",
     *                       description="ID of customer's payment",
     *                       type="Integer",
     *                   ),
     *                    @OA\Property(
     *                        property="method_id",
     *                        description="ID of payment's method",
     *                        type="Integer",
     *                    ),
     *                     @OA\Property(
     *                        property="basket_id",
     *                        description="ID of basket's payment",
     *                        type="Integer",
     *                    ),
     *                     @OA\Property(
     *                        property="Amount",
     *                        description="Amount of payment",
     *                        type="float",
     *                    ),
     *                     @OA\Property(
     *                        property="is_completed",
     *                        description="If payment was completed",
     *                        type="bool",
     *                    ),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *           response=200,
     *           description="payment was initiated",
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
        $customerId = filter_var($responseBody['customer_Id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $methodId = filter_var($responseBody['method_Id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $amount = filter_var($responseBody['amount'], FILTER_SANITIZE_SPECIAL_CHARS);
        $isCompleted = filter_var($responseBody['is_completed'], FILTER_SANITIZE_SPECIAL_CHARS);

        $this->model = new Payments();
        $this->model->setCustomersId((int)$customerId);
        $this->model->setmethodId((int)$methodId);
        $this->model->setAmount((float)$amount);
        $this->model->setIsCompleted((bool)$isCompleted);

        return parent::createAction($request, $response);
    }

    /**
     * @OA\Put(
     *      path="/v1/payments/{id}",
     *      description="update a single payment based on payment's ID",
     *      @OA\Parameter(
     *           description="ID of a payment to update",
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
     *                        property="customer_id",
     *                        description="ID of customer's payment",
     *                        type="Integer",
     *                    ),
     *                     @OA\Property(
     *                         property="method_id",
     *                         description="ID of payment's method",
     *                         type="Integer",
     *                     ),
     *                      @OA\Property(
     *                         property="basket_id",
     *                         description="ID of basket's payment",
     *                         type="Integer",
     *                     ),
     *                      @OA\Property(
     *                         property="Amount",
     *                         description="Amount of payment",
     *                         type="float",
     *                     ),
     *                      @OA\Property(
     *                         property="is_completed",
     *                         description="If payment was completed",
     *                         type="bool",
     *                     ),
     *                ),
     *            ),
     *        ),
     *  @OA\Response(
     *            response=200,
     *            description="A payment was initiated",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="payment not found",
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
        $responseBody = Json_decode($request->getBody()->getContents(), true);
        $customerId = filter_var($responseBody['customer_Id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $methodId = filter_var($responseBody['method_Id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $amount = filter_var($responseBody['amount'], FILTER_SANITIZE_SPECIAL_CHARS);
        $isCompleted = filter_var($responseBody['is_completed'], FILTER_SANITIZE_SPECIAL_CHARS);

        $payment = $this->repository->findById($args['Id']);
        if(is_null($payment)){

            $context = [
                'type' => 'error/no_payment_found_upon_update',
                'title' => 'List of payments',
                'status' => 400,
                'detail' => $args['Id'],
                'instance' => '/v1/payments/{Id} '
            ];
            $this->logger->info('No  payments found', $context);
            return new JsonResponse('$context', 400);
        }
        $this->model = $payment;
        $this->model->setCustomersId((int)$customerId);
        $this->model->setmethodId((int)$methodId);
        $this->model->setAmount((float)$amount);
        $this->model->setIsCompleted((bool)$isCompleted);

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
     *      path="/v1/payments/reactivate/{id}",
     *      description="Reactivates a single payment method based on method's ID",
     *      @OA\Parameter(
     *           description="ID of a payment to update",
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
     *            description="Payment has been reactivated successfully",
     *        ),
     *  @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     *      @OA\Response(
     *                 response=404,
     *             description="Paymenet not found",
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
     *      path="/v1/payments/{id}",
     *      description="deletes a single payment based on payment's ID",
     *      @OA\Parameter(
     *          description="ID of payment to be deleted",
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
     *              description="Payment not found",
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