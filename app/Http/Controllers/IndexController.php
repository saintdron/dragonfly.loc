<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends SiteController
{
    public function __construct()
    {
        $this->template = 'common';
        $this->keywords = 'портфолио, веб-разработка, веб-дизайн, программирование';
        $this->meta_desc = 'Сайт-портфолио для демонстрации навыков в областях программирования и веб-дизайна';
    }

    public function index(Request $request)
    {
        $content_view = view('index_content')
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }
}
