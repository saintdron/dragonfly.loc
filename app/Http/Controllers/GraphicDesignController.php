<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BrandingRepository;
use App\Http\Repositories\GraphicAnimationRepository;
use App\Http\Repositories\PrintingRepository;
use Illuminate\Http\Request;

class GraphicDesignController extends SiteController
{
    public function __construct(BrandingRepository $br_rep, PrintingRepository $pr_rep, GraphicAnimationRepository $ga_rep)
    {
        parent::__construct();

        $this->title = 'Графический дизайн';
        $this->template = 'common';
        $this->navPosition = 'left-bottom';

        $this->br_rep = $br_rep;
        $this->pr_rep = $pr_rep;
        $this->ga_rep = $ga_rep;
    }

    public function branding(Request $request, $alias = false)
    {
        session(['graphicDesignLast' => 'branding']);

        $works = $this->getBrandings();
        $selected = $this->getBranding($alias ?: $works[0]->alias);

        $k = $works->search(function ($item) use ($selected) {
            return $item->alias === $selected->alias;
        });
        $selected->prev = ($k === 0) ? $works[count($works) - 1] : $works[$k - 1];
        $selected->next = ($k === count($works) - 1) ? $works[0] : $works[$k + 1];

        $content_view = view('branding_content')
            ->with(['title' => $this->title, 'selected' => $selected, 'works' => $works])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    public function printing(Request $request, $alias = false)
    {
        session(['graphicDesignLast' => 'printing']);

        $works = $this->getPrintings();
        $selected = $this->getPrinting($alias ?: $works[0]->alias);

        $k = $works->search(function ($item) use ($selected) {
            return $item->alias === $selected->alias;
        });
        $selected->prev = ($k === 0) ? $works[count($works) - 1] : $works[$k - 1];
        $selected->next = ($k === count($works) - 1) ? $works[0] : $works[$k + 1];

        $content_view = view('printing_content')
            ->with(['title' => $this->title, 'selected' => $selected, 'works' => $works])
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
        $selected = $this->getGraphicAnimation($alias ?: $works[0]->alias);

        $k = $works->search(function ($item) use ($selected) {
            return $item->alias === $selected->alias;
        });
        $selected->prev = ($k === 0) ? $works[count($works) - 1] : $works[$k - 1];
        $selected->next = ($k === count($works) - 1) ? $works[0] : $works[$k + 1];

//        dd($works);

        $content_view = view('graphic-animations_content')
            ->with(['title' => $this->title, 'selected' => $selected, 'works' => $works])
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

    protected function getPrintings()
    {
        return $this->pr_rep->get(['img', 'title', 'alias']);
    }

    protected function getPrinting($alias)
    {
        return $this->pr_rep->one($alias, ['img', 'title', 'alias', 'text', 'customer', 'techs', 'created_at']);
    }

    protected function getGraphicAnimations()
    {
        return $this->ga_rep->get(['img', 'title', 'alias']);
    }

    protected function getGraphicAnimation($alias)
    {
        return $this->ga_rep->one($alias, ['video', 'img', 'title', 'alias', 'text', 'customer', 'techs', 'created_at']);
    }

}