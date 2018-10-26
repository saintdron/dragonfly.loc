<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends SiteController
{
    public function __construct() {
        $this->template = 'index';
    }

    public function index() {
        $this->keywords = 'портфолио, веб-разработка, веб-дизайн, программирование';
        $this->meta_desc = 'Сайт-портфолио для демонстрации навыков в областях веб-разработки и дизайна';

        return $this->renderOutput();
    }
}
