<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ajax;

use App\Helpers\ErrorMessage;
use App\Models\Package;
use App\Models\PackageDay;
use Illuminate\Http\JsonResponse;

/**
 * Class PackageController
 *
 * @description Контроллер тарифов.
 */
class PackageController extends BaseController
{
    /**
     * Список тарифов.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $isSuccess = false;

        try {
            $data = Package::query()->get(['id', 'name', 'price']);

            $isSuccess = true;
        } catch (\Throwable $e) {
            $data = ErrorMessage::getResponseMessage($e);
        }

        return $this->response($data, $isSuccess);
    }

    /**
     * Получить дни недели для тарифного плана.
     *
     * @param int $packageId
     *
     * @return JsonResponse
     */
    public function daysOfWeak(int $packageId): JsonResponse
    {
        $isSuccess = false;

        try {
            $data = PackageDay::query()->where('package_id', $packageId)->get('day_id');

            $isSuccess = true;
        } catch (\Throwable $e) {
            $data = ErrorMessage::getResponseMessage($e);
        }

        return $this->response($data, $isSuccess);
    }
}
