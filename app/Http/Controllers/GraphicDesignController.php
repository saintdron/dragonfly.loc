<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BrandingRepository;
use Illuminate\Http\Request;

class GraphicDesignController extends SiteController
{
    protected $partition; // the name of current partition

    public function __construct(BrandingRepository $br_rep)
    {
        parent::__construct();

        $this->template = 'common';
        $this->navPosition = 'left-bottom';

        $this->br_rep = $br_rep;
    }

    public function branding(Request $request, $alias = false)
    {
        $this->partition = 'branding';
        session(['graphicDesignLast' => $this->partition]);

        $works = $this->getBrandings();
        $selected = $this->getBranding($alias ?: $works[0]->alias);

        $key = $works->search(function ($item) use ($selected) {
            return $item->alias === $selected->alias;
        });
        $selected->prevAlias = ($key === 0) ? $works[count($works) - 1]->alias : $works[$key - 1]->alias;
        $selected->nextAlias = ($key === count($works) - 1) ? $works[0]->alias : $works[$key + 1]->alias;

        $content_view = view('graphic-design_content')
            ->with(['partition' => $this->partition, 'selected' => $selected, 'works' => $works])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    public function printing(Request $request, $alias = false)
    {
        $this->partition = 'printing';
        session(['graphicDesignLast' => $this->partition]);

        $works = $this->getPrinting();

        $content_view = view('graphic-design_content')
            ->with(['works' => $works, 'partition' => $this->partition])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    public function graphicAnimations(Request $request, $alias = false)
    {
        $this->partition = 'graphicAnimations';
        session(['graphicDesignLast' => $this->partition]);

        $works = $this->getGraphicAnimations();

        $content_view = view('graphic-animations_content')
            ->with(['works' => $works, 'partition' => $this->partition])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    protected function getBrandings()
    {
        return $this->br_rep->get(['img', 'title', 'alias']);
    }

    protected function getBranding($alias)
    {
        return $this->br_rep->one($alias, ['img', 'title', 'alias', 'text', 'customer', 'techs', 'created_at']);
    }

    protected function getPrinting()
    {
        return [];
    }

    protected function getGraphicAnimations()
    {
        return [];
    }

}