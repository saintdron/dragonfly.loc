<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $g_rep; // GraphicRepository
    protected $w_rep; // WebRepository
    protected $s_rep; // SkillsRepository
    protected $cv_rep; // CVRepository

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template; // the name of the returned template
    protected $vars = []; // list of variables to be passed to the template

    protected $navPosition; // the menu position
//    protected $webDevelopmentLast; // last selected subsection in the web-development section
//    protected $graphicDesignLast; // last selected subsection in the graphic-design section


    public function __construct()
    {

    }

    protected function renderOutput()
    {
        $navigation_view = view('navigation')
            ->with(['menu' => $this->getMenu(), 'navPosition' => $this->navPosition])
            ->render();
        $this->vars = array_add($this->vars, 'navigation_view', $navigation_view);

        $this->vars = array_merge($this->vars, [
            'keywords' => $this->keywords,
            'meta_desc' => $this->meta_desc,
            'title' => $this->title,
            'template' => $this->template
        ]);

        return view($this->template)
            ->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = [];
        $menu[] = route(session('webDevelopmentLast', 'branding'));
        $menu[] = route(session('graphicDesignLast', 'sites'));
        $menu[] = route('skills');
        $menu[] = route('cv');
        return $menu;
    }
}
