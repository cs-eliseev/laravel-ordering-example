<?php

namespace App\Http\Controllers;

use App\Components\PageComponent\Models\PageModel;
use App\Components\PageComponent\Page;
use Illuminate\View\View;

/**
 * Class BaseController
 *
 * @description Базовый класс для контроллеров.
 */
class BaseController extends Controller
{
    /**
     * Рендер страницы.
     *
     * @param PageModel $page
     *
     * @return View
     */
    protected function render(PageModel $page): View
    {
        return view('templates.index', [
            'page' => $page
        ]);
    }

    /**
     * Сформировать данные страницы.
     *
     * @param array $params
     *
     * @return PageModel
     */
    protected function getPage(array $params): PageModel
    {
        $page = new Page($params);

        return $page->getPage();
    }
}
