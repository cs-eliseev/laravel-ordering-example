<?php

declare(strict_types=1);

namespace Tests\OrderServices;

use App\Config\DateConfig;
use App\Config\ExceptionCodeConfig;
use App\Helpers\ErrorMessage;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageDay;
use App\Models\Phone;
use App\Services\OrderService\Exceptions\OrderLogicException;
use App\Services\OrderService\OrderService;
use Carbon\Carbon;
use Tests\TestCase;

class OrderServicesTest extends TestCase
{
    /**
     * @var Package $testPackage
     */
    protected static $testPackage;

    /**
     * @var PackageDay $deliveryDay
     */
    protected static $deliveryDay;

    /**
     * @var OrderService $orderService
     */
    protected static $orderService;

    protected static $createData = true;
    protected static $removeData = false;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        if (self::$createData) {
            self::$testPackage = new Package();
            self::$testPackage->name = 'test_' . rand(0, 9000);
            self::$testPackage->price = 100;
            self::$testPackage->save();

            self::$deliveryDay = new PackageDay();
            self::$deliveryDay->package_id = self::$testPackage->id;
            self::$deliveryDay->day_id = Carbon::now()->dayOfWeek ?: 7;
            self::$deliveryDay->save();

            self::$orderService = new OrderService();

            self::$createData = false;
        }
    }

    protected function tearDown(): void
    {
        if (self::$removeData) {
            self::$deliveryDay->delete();
            self::$testPackage->delete();

            self::$removeData = false;
        }

        parent::tearDown();
    }

    /**
     * Проверка ошибки на несуществующий пакет.
     */
    public function testUndefinedPackage(): void
    {
        try {
            $packageId = 9000000000000;

            self::$orderService->create([
                'name' => 'Тестоавый Пользователь',
                'price' => '100',
                'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
                'delivery' => Carbon::now()->format(DateConfig::NORMAL_FULL),
                'phone' => '+79110064400',
                'package' => $packageId,
            ]);

            $this->expectException(ErrorMessage::getErrorMsg(
                ExceptionCodeConfig::ORDER_MODEL_UNDEFINED_PACKAGE,
                ['package' => $packageId]
            ));
        } catch (OrderLogicException $e) {
            $this->assertEquals($e->getCode(), ExceptionCodeConfig::ORDER_MODEL_UNDEFINED_PACKAGE);
        }
    }

    /**
     * Проверка ошибки в изменении стоимости.
     */
    public function testChangePrice(): void
    {
        try {
            $price = '99.99';

            self::$orderService->create([
                'name' => 'Тестоавый Пользователь',
                'price' => $price,
                'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
                'delivery' => Carbon::now()->format(DateConfig::NORMAL_FULL),
                'phone' => '+79110064400',
                'package' => self::$testPackage->id,
            ]);

            $this->expectException(ErrorMessage::getErrorMsg(
                ExceptionCodeConfig::ORDER_MODEL_CHANGE_PRICE,
                [
                    'price_old' => $price,
                    'price_new' => self::$testPackage->price
                ]
            ));
        } catch (OrderLogicException $e) {
            $this->assertEquals($e->getCode(), ExceptionCodeConfig::ORDER_MODEL_CHANGE_PRICE);
        }
    }

    /**
     * Проверка не допустимых дней.
     */
    public function testNotDeliveryDay(): void
    {
        try {
            $day = Carbon::now()->addDay();

            self::$orderService->create([
                'name' => 'Тестоавый Пользователь',
                'price' => '100',
                'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
                'delivery' => $day->format(DateConfig::NORMAL_FULL),
                'phone' => '+79110064400',
                'package' => self::$testPackage->id,
            ]);

            $this->expectException(ErrorMessage::getErrorMsg(
                ExceptionCodeConfig::ORDER_MODEL_NOT_DELIVERY_DAY,
                ['day' => $day->dayOfWeek ?: 7]
            ));
        } catch (OrderLogicException $e) {
            $this->assertEquals($e->getCode(), ExceptionCodeConfig::ORDER_MODEL_NOT_DELIVERY_DAY);
        }
    }

    /**
     * Проверка предыдущего дня.
     */
    public function testLastDay(): void
    {
        try {
            $day = Carbon::now()->subDay(7);
            self::$orderService->create([
                'name' => 'Тестоавый Пользователь',
                'price' => '100',
                'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
                'delivery' => $day->format(DateConfig::NORMAL_FULL),
                'phone' => '+79110064400',
                'package' => self::$testPackage->id,
            ]);

            $this->expectException(ErrorMessage::getErrorMsg(ExceptionCodeConfig::ORDER_MODEL_LAST_DAY));
        } catch (OrderLogicException $e) {
            $this->assertEquals($e->getCode(), ExceptionCodeConfig::ORDER_MODEL_LAST_DAY);
        }
    }

    /**
     * Проверка создания заказа.
     */
    public function testCreate(): void
    {
        do {
            $phone = rand(11, 34);
        } while (Phone::query()->where('number', $phone)->exists());

        $orderId = self::$orderService->create([
            'name' => 'Тестоавый Пользователь',
            'price' => '100',
            'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
            'delivery' => Carbon::now()->format(DateConfig::NORMAL_FULL),
            'phone' => "+{$phone}",
            'package' => self::$testPackage->id,
        ]);

        $this->assertNotNull($orderId);

        $order = Order::find($orderId);
        $client = $order->client;
        $phone = $client->phone;
        $address = $client->address;
        $this->assertTrue($order->delete());
        $this->assertTrue($client->delete());
        $this->assertTrue($phone->delete());
        $this->assertTrue($address->delete());
    }

    /**
     * Проверка создания заказа с повторяющимся номером.
     */
    public function testRepeatNumber(): void
    {
        do {
            $phone = rand(11, 34);
        } while (Phone::query()->where('number', $phone)->exists());

        $orderId1 = self::$orderService->create([
            'name' => 'Тестоавый Пользователь',
            'price' => '100',
            'address' => 'Санкт-Петербург, Финльяндский проспект, д. 4',
            'delivery' => Carbon::now()->format(DateConfig::NORMAL_FULL),
            'phone' => "+{$phone}",
            'package' => self::$testPackage->id,
        ]);

        $this->assertNotNull($orderId1);

        $orderId2 = self::$orderService->create([
            'name' => 'Тестоавый Пользователь 2',
            'price' => '100',
            'address' => 'Санкт-Петербург, Набережная р. Мойки, д. 10',
            'delivery' => Carbon::now()->format(DateConfig::NORMAL_FULL),
            'phone' => "+{$phone}",
            'package' => self::$testPackage->id,
        ]);

        $this->assertNotNull($orderId2);

        $order1 = Order::find($orderId1);
        $order2 = Order::find($orderId2);

        $this->assertEquals($order1->client, $order2->client);

        $client = $order1->client;
        $phone = $client->phone;
        $address = $client->address;
        $this->assertTrue($order1->delete());
        $this->assertTrue($order2->delete());
        $this->assertTrue($client->delete());
        $this->assertTrue($phone->delete());
        $this->assertTrue($address->delete());

        self::$removeData = true;
    }
}
