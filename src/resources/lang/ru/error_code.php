<?php

use App\Config\ExceptionCodeConfig;

return [
    ExceptionCodeConfig::UNKNOWN_ERROR => 'Что то пошло не так',

    ExceptionCodeConfig::ORDER_MODEL_ARGUMENT_IS_NOT_SET => 'Параметр ":name" не установлен',
    ExceptionCodeConfig::ORDER_MODEL_UNDEFINED_PACKAGE => 'Неизвестный тариф: ":package"',
    ExceptionCodeConfig::ORDER_MODEL_CHANGE_PRICE => 'Стоимость изменена с ":price_old" на ":price_new"',
    ExceptionCodeConfig::ORDER_MODEL_NOT_DELIVERY_DAY => 'Заказ не может быть доставлен в ":day"',
    ExceptionCodeConfig::ORDER_MODEL_LAST_DAY => 'Оформление на прошедшие даты не доступно',
];
