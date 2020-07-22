<?php

declare(strict_types=1);

namespace App\Services\OrderService\Handlers;

use App\Config\DateConfig;
use App\Config\ExceptionCodeConfig;
use App\Models\Package;
use App\Services\OrderService\Exceptions\OrderLogicException;
use App\Services\OrderService\Models\OrderCreateModels;
use Carbon\Carbon;

/**
 * Class OrderCreate
 *
 * @description Валидация заказа.
 */
class OrderCreateValidation
{
    /**
     * @var OrderCreateModels
     */
    protected $orderData;

    /**
     * OrderCreate constructor.
     *
     * @param OrderCreateModels $orderData
     */
    public function __construct(OrderCreateModels $orderData)
    {
        $this->orderData = $orderData;
    }

    public function run(): void
    {
        $package = Package::find($this->orderData->getPackageId());
        if (empty($package)) {
            OrderLogicException::throwException(
                ExceptionCodeConfig::ORDER_MODEL_UNDEFINED_PACKAGE,
                ['package' => $this->orderData->getPackageId()]
            );
        }

        if ($package->price != $this->orderData->getPrice()) {
            OrderLogicException::throwException(
                ExceptionCodeConfig::ORDER_MODEL_CHANGE_PRICE,
                [
                    'price_old' => $this->orderData->getPrice(),
                    'price_new' => $package->price,
                ]
            );
        }

        $dayOfWeek = $this->orderData->getDeliveryAt()->dayOfWeek ?: 7;
        $items = $package->days()->where('dictionary_days.id', $dayOfWeek)->get();
        if ($items->count() == 0) {
            OrderLogicException::throwException(
                ExceptionCodeConfig::ORDER_MODEL_NOT_DELIVERY_DAY,
                ['day' => DateConfig::getDayShortName($dayOfWeek)]
            );
        }

        if ($this->orderData->getDeliveryAt() < Carbon::now()->setTime(0, 0, 0)) {
            OrderLogicException::throwException(ExceptionCodeConfig::ORDER_MODEL_LAST_DAY);
        }
    }
}
