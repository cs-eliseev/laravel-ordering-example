<?php

declare(strict_types=1);

namespace App\Services\OrderService\Models;

use App\Config\DateConfig;
use App\Config\ExceptionCodeConfig;
use App\Services\OrderService\Exceptions\OrderLogicException;
use Carbon\Carbon;
use ReflectionClass;

/**
 * Class OrderCreateModels
 *
 * @description Модель данных заказа.
 */
class OrderCreateModels
{
    /**
     * @var integer $package_id
     */
    protected $package_id;

    /**
     * @var integer $phone
     */
    protected $phone;

    /**
     * @var Carbon $delivery_at
     */
    protected $delivery_at;

    /**
     * @var float $price
     */
    protected $price;

    /**
     * @var string $address
     */
    protected $address;

    /**
     * @var string $name
     */
    protected $name;

    public function __construct(array $param)
    {
        $this->name = $param['name'] ?? '';
        $this->price = floatval($param['price'] ?? 0);
        $this->address = $param['address'] ?? '';
        $this->delivery_at = Carbon::parse($param['delivery'] ?? '');
        $this->phone = (int) preg_replace('/\D{7,34}/', '', $param['phone'] ?? '');
        $this->package_id = (int) $param['package'] ?? 0;
    }

    /**
     * get PackageId
     *
     * @return int
     */
    public function getPackageId(): int
    {
        return $this->package_id;
    }

    /**
     * get Phone
     *
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * get DeliveryAt
     *
     * @return Carbon
     */
    public function getDeliveryAt(): Carbon
    {
        return $this->delivery_at;
    }

    /**
     * get Price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * get Address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
