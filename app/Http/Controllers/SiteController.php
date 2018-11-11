<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $br_rep; // BrandingRepository
    protected $pr_rep; // PrintingRepository
    protected $ga_rep; // GraphicAnimationsRepository

    protected $si_rep; // SitesRepository
    protected $se_rep; // ServicesRepository
    protected $wa_rep; // WebAnimationsRepository

    protected $sk_rep; // SkillsRepository

    protected $cv_rep; // CVRepository

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template; // the name of the returned template
    protected $vars = []; // list of variables to be passed to the template

    protected $navPosition; // the menu position
    protected $partition; // current partition
    protected $partitions_view; // returned view of partitions


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
            'title' => $this->title
        ]);

        return view($this->template)
            ->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = [];
        $menu[] = route(session('webDevelopmentLast', 'sites'));
        $menu[] = route(session('graphicDesignLast', 'branding'));
        $menu[] = route('cv');
        $menu[] = route('skills');
        return $menu;
    }
}
