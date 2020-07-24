<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ajax;

use App\Config\ExceptionCodeConfig;
use App\Helpers\ErrorMessage;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService\Exceptions\OrderLogicException;
use App\Services\OrderService\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrderController
 *
 * @description Обработка заказа.
 */
class OrderController extends BaseController
{
    /**
     * Оформление заказа.
     *
     * @param OrderRequest $request
     *
     * @return JsonResponse
     */
    public function create(OrderRequest $request): JsonResponse
    {
        $isSuccess = false;

        try {
            $orderService = new OrderService();
            $data = collect([
                'orderId' => $orderService->create($request->toArray()),
            ]);

            $isSuccess = true;
        } catch (\Throwable $e) {
            $data = ErrorMessage::getResponseMessage($e);
        }

        return $this->response($data, $isSuccess);
    }
}
