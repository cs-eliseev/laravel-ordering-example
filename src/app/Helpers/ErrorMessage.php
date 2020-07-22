<?php

namespace App\Helpers;

use App\Config\ErrorConfig;
use App\Config\ExceptionCodeConfig;
use App\Exceptions\BaseExceptionInterface;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Class ErrorMessage
 *
 * @description Дополнительный функционал для обработки ошибок.
 */
class ErrorMessage
{
    /**
     * Получить сообщение об ошибки для фронта.
     *
     * @param Throwable $e
     *
     * @return Collection
     */
    public static function getResponseMessage(Throwable $e): Collection
    {
        $code = ExceptionCodeConfig::UNKNOWN_ERROR;
        $params = [];

        if ($e instanceof BaseExceptionInterface) {
            $code = $e->getCode();
            $params = $e->getMsgParams();
        }

        $msg = trans("error_code.{$code}", $params, ErrorConfig::LOCAL_FRONT);

        logger(self::getDebugInfoByException($e));

        return collect([
           'code' => $e->getCode(),
           'message' => $msg,
        ]);
    }


    /**
     * Получить отладочную информаицб из исключения.
     *
     * @param Throwable $exception
     *
     * @return string
     */
    public static function getDebugInfoByException(Throwable $exception): string
    {
        return "Exception message: [{$exception->getCode()}] {$exception->getMessage()}" . PHP_EOL . $exception->getTraceAsString();
    }
}
