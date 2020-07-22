<?php

declare(strict_types=1);

namespace App\Services\OrderService\Handlers;

use App\Models\Address;
use App\Models\AddressType;
use App\Models\Client;
use App\Models\Order;
use App\Models\Package;
use App\Models\Phone;
use App\Models\PhoneType;
use App\Services\OrderService\Models\OrderCreateModels;

/**
 * Class OrderCreate
 *
 * @description Создание заказа.
 */
class OrderCreate
{
    /**
     * @var OrderCreateModels
     */
    protected $orderData;

    /**
     * @var Phone $phone
     */
    protected $phone;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var Address $address
     */
    protected $address;

    /**
     * @var Package $package
     */
    protected $package;

    /**
     * OrderCreate constructor.
     *
     * @param OrderCreateModels $orderData
     */
    public function __construct(OrderCreateModels $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * @return int
     */
    public function run(): int
    {
        $this->buildAddress();
        $this->buildPhone();
        $this->buildClient();
        $this->buildPackage();

        $order = new Order();
        $order->name = $this->orderData->getName();
        $order->package()->associate($this->package);
        $order->price = $this->orderData->getPrice();
        $order->client()->associate($this->client);
        $order->address()->associate($this->address);
        $order->delivery_at = $this->orderData->getDeliveryAt();
        $order->save();

        return $order->id;
    }

    /**
     * Инициализация адреса.
     */
    protected function buildAddress(): void
    {
        $this->address = new Address();
        $this->address->type_id = AddressType::ORDER;
        $this->address->full = $this->orderData->getAddress();
        $this->address->save();
    }

    /**
     * Инициализация телефона.
     */
    protected function buildPhone(): void
    {
        $this->phone = Phone::query()->where('number', $this->orderData->getPhone())->where('type_id', PhoneType::ORDER)->first();

        if (empty($this->phone)) {
            $this->phone = new Phone();
            $this->phone->type_id = PhoneType::ORDER;
            $this->phone->number = $this->orderData->getPhone();
            $this->phone->save();
        }
    }

    /**
     * Инициализация клиента.
     */
    protected function buildClient(): void
    {
        $this->client = Client::query()->where('phone_id', $this->phone->id)->first();

        if (empty($this->client)) {
            $this->client = new Client();
            $this->client->name = $this->orderData->getName();
            $this->client->phone()->associate($this->phone);
            $this->client->address()->associate($this->address);
        }

        $this->client->save();
    }

    /**
     * Инициализация тарифа.
     */
    protected function buildPackage(): void
    {
        $this->package = Package::find($this->orderData->getPackageId());
    }
}
