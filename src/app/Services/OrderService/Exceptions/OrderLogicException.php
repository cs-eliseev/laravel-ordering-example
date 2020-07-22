<?php

declare(strict_types=1);

namespace App\Services\OrderService\Exceptions;

use App\Exceptions\BaseExceptionInterface;
use App\Exceptions\BaseExceptionTrait;
use LogicException;
use Throwable;

/**
 * Class OrderLogicExceptions
 */
class OrderLogicException extends LogicException implements Throwable, BaseExceptionInterface
{
    use BaseExceptionTrait;
}
