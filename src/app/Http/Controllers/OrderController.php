<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;
/**
 * Class OrderController
 *
 * @description Контроллер заказов.
 */
class OrderController extends BaseController
{
    /**
     * Форма заказа.
     *
     * @return View
     */
    public function index(): View
    {
        return $this->render($this->getPage(['title' => 'Форма заказа']));
    }
}
