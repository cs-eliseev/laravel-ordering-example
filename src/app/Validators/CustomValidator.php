<?php

declare(strict_types=1);

namespace App\Validators;

use Illuminate\Validation\Validator;

/**
 * Class CustomValidator
 *
 * @description Расширение валидатора.
 */
class CustomValidator extends Validator
{
    /**
     * @param $attribute
     * @param $value
     *
     * @return false|int
     */
    protected function validatePhoneSimple($attribute, $value)
    {
        return preg_match('/^\+?(\d){6,20}$/', $value);
    }

    /**
     * @param $attribute
     * @param $value
     *
     * @return false|int
     */
    protected function validateTextRu($attribute, $value)
    {
        return preg_match('/[а-яА-Я ]+/u', $value);
    }

    /**
     * @param $attribute
     * @param $value
     *
     * @return false|int
     */
    protected function validateAddressRU($attribute, $value)
    {
        return preg_match('/[а-яА-Я\d\-,. \/\(\)]+$/u', $value);
    }
}
