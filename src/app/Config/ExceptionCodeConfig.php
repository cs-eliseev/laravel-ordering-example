<?php

namespace App\Config;

/**
 * Class ExceptionCodeConfig
 *
 * @description Коды ошибок.
 */
class ExceptionCodeConfig
{
    public const UNKNOWN_ERROR = 0;

    public const ORDER_MODEL_ARGUMENT_IS_NOT_SET = 10000;
    public const ORDER_MODEL_UNDEFINED_PACKAGE = 10001;
    public const ORDER_MODEL_CHANGE_PRICE = 10002;
    public const ORDER_MODEL_NOT_DELIVERY_DAY = 10003;
    public const ORDER_MODEL_LAST_DAY = 10004;
}
