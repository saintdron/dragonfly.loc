<?php

namespace App\Http\Controllers;

use App\Repositories\BrandingRepository;
use App\Repositories\GraphicAnimationRepository;
use App\Repositories\PrintingRepository;
use Illuminate\Http\Request;

class GraphicDesignController extends SiteController
{
    public function __construct(BrandingRepository $br_rep, PrintingRepository $pr_rep, GraphicAnimationRepository $ga_rep)
    {
        parent::__construct();

        $this->title = 'Графический дизайн';
        $this->template = 'common';
        $this->nav_position = 'left-bottom';

        $this->br_rep = $br_rep;
        $this->pr_rep = $pr_rep;
        $this->ga_rep = $ga_rep;
    }

    public function branding(Request $request, $alias = false)
    {
        $this->partition = 'branding';
        $this->partitions_view = $this->getPartitionsView();

        try {
//            throw new \Exception('Тестовое исключение');
            $works = $this->getBrandings();
            if ($works->isEmpty()) {
                $content_view = $this->setError('Не удалось найти ни одной работы.');
            } else {
                $selected = $alias ? $this->getBranding($alias) : $this->getBranding($works[0]->alias);
                $selected = $selected ?: $this->getBranding($works[0]->alias);
                $content_view = $this->formContent($works, $selected);
            }
        } catch (\Exception $exception) {
            report($exception);
            $content_view = $this->setError();
        }

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);
        return $this->renderOutput();
    }

    public function printing(Request $request, $alias = false)
    {
        $this->partition = 'printing';
        $this->partitions_view = $this->getPartitionsView();

        try {
            $works = $this->getPrintings();
            if ($works->isEmpty()) {
                $content_view = $this->setError('Не удалось найти ни одной работы.');
            } else {
                $selected = $alias ? $this->getPrinting($alias) : $this->getPrinting($works[0]->alias);
                $selected = $selected ?: $this->getPrinting($works[0]->alias);
                $content_view = $this->formContent($works, $selected);
            }
        } catch (\Exception $exception) {
            report($exception);
            $content_view = $this->setError();
        }

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);
        return $this->renderOutput();
    }

    public function graphicAnimations(Request $request, $alias = false)
    {
        $this->partition = 'graphicAnimations';
        $this->partitions_view = $this->getPartitionsView();

        try {
            $works = $this->getGraphicAnimations();
            if ($works->isEmpty()) {
                $content_view = $this->setError('Не удалось найти ни одной работы.');
            } else {
                $selected = $alias ? $this->getGraphicAnimation($alias) : $this->getGraphicAnimation($works[0]->alias);
                $selected = $selected ?: $this->getGraphicAnimation($works[0]->alias);
                $content_view = $this->formContent($works, $selected);
            }
        } catch (\Exception $exception) {
            report($exception);
            $content_view = $this->setError();
        }

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);
        return $this->renderOutput();
    }

    protected function getPartitionsView()
    {
        session(['graphicDesignLast' => $this->partition]);
        return view('graphicDesignPartitions_content')
            ->with(['partition' => $this->partition])
            ->render();
    }

    protected function formContent($works, $selected)
    {
        // Определение порядкового номера выбранной работы
        $k = $works->search(function ($item) use ($selected) {
            return $item->alias === $selected->alias;
        });
        $selected->prev = ($k === 0) ? $works[count($works) - 1] : $works[$k - 1];
        $selected->next = ($k === count($works) - 1) ? $works[0] : $works[$k + 1];

        return view($this->partition . '_content')
            ->with(['title' => $this->title, 'partitions_view' => $this->partitions_view, 'selected' => $selected, 'works' => $works])
            ->render();
    }

    protected function getBrandings()
    {
        return $this->br_rep->get(['img', 'title', 'alias']/*, ['id', '>', '100']*/);
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