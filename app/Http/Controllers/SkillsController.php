<?php

namespace App\Http\Controllers;

use App\Repositories\SkillRepository;
use Illuminate\Http\Request;

class SkillsController extends SiteController
{
    public function __construct(SkillRepository $sk_rep)
    {
        parent::__construct();

        $this->title = 'Навыки';
        $this->template = 'common';
        $this->navPosition = 'left-top';

        $this->sk_rep = $sk_rep;
    }

    public function index(Request $request)
    {
        $skills = $this->getSkills();

        $content_view = view('skills_content')
            ->with(['title' => $this->title, 'skills' => $skills])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    protected function getSkills()
    {
        return $this->sk_rep->get(['tech', 'level', 'order']);
    }
}
