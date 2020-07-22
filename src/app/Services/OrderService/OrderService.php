<?php

declare(strict_types=1);

namespace App\Services\OrderService;

use App\Services\OrderService\Handlers\OrderCreate;
use App\Services\OrderService\Handlers\OrderCreateValidation;
use App\Services\OrderService\Models\OrderCreateModels;

/**
 * Class OrderService
 *
 * @description Управление заказами.
 */
class OrderService
{
    /**
     * @param array $params
     *
     * @return int
     */
    public function create(array $params): int
    {
        $orderData = new OrderCreateModels($params);

        (new OrderCreateValidation($orderData))->run();
        return (new OrderCreate($orderData))->run();
    }
}
