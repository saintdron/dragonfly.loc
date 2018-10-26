<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraphicDesignController extends SiteController
{
    public function __construct()
    {
        parent::__construct();

        $this->template = 'graphic-design';
        $this->navPosition = 'right-bottom';
    }

    public function branding(Request $request, $alias = false)
    {
        $branding = false;

        $content_view = view($this->template . '_content')
            ->with(['branding' => $branding, 'partition' => 'branding'])
            ->render();

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    public function printing(Request $request, $alias = false)
    {

    }

    public function animations(Request $request, $alias = false)
    {

    }
}
/*
public function __construct(MenuRepository $m_rep, PortfolioRepository $p_rep, ArticleRepository $a_rep, CommentRepository $c_rep, CategoryRepository $cat_rep)
{
    parent::__construct($m_rep);

    $this->template = 'articles';
    $this->bar = 'right';
    $this->p_rep = $p_rep;
    $this->a_rep = $a_rep;
    $this->c_rep = $c_rep;
    $this->cat_rep = $cat_rep;
}

public function index($cat_alias = false)
{
    $category = $this->getCategory($cat_alias);
    $this->title = $category->title;
    $this->keywords = $category->keywords;
    $this->meta_desc = $category->meta_desc;

    $articles = $this->getArticles($cat_alias);

    $content_view = view(config('settings.theme') . '.articles_content')
        ->with('articles', $articles)
        ->render();
    $this->vars = array_add($this->vars, 'content_view', $content_view);

    $this->formContentRightBar();

    return $this->renderOutput();
}

public function show($alias)
{
    $article = $this->getArticle($alias);
    if ($article) {
        $this->title = $article->title;
        $this->keywords = $article->keywords;
        $this->meta_desc = $article->meta_desc;
        $this->stickyBar = true;

        $content_view = view(config('settings.theme') . '.article_content')
            ->with('article', $article)
            ->render();
    } else {
        $content_view = "<p>Указанный материал не найден</p>";
    }
    $this->vars = array_add($this->vars, 'content_view', $content_view);

    $this->formContentRightBar();

    return $this->renderOutput();
}

protected function getArticles($cat_alias = false)
{
    $where = false;
    if ($cat_alias) {
        $id = Category::select('id')->where('alias', $cat_alias)->first()->id;
        $where = ['category_id', $id];
    }

    return $this->a_rep->get(['id', 'title', 'text', 'desc', 'alias', 'img', 'created_at', 'user_id', 'category_id', 'keywords', 'meta_desc'],
        false, Config::get('settings.articles_paginate'), $where);
}

protected function getArticle($alias)
{
    return $this->a_rep->one($alias);
}

protected function formContentRightBar()
{
    $comments = $this->getComments(config('settings.recent_comments'));
    $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
    $this->contentRightBar = view(config('settings.theme') . '.articlesBar')
        ->with(['comments' => $comments, 'portfolios' => $portfolios]);
}

protected function getComments($take)
{
    $comments = $this->c_rep->get(['name', 'email', 'text', 'site', 'article_id', 'user_id'], $take);
    if ($comments) {
        $comments->load('article', 'user');
    }
    return $comments;
}

protected function getPortfolios($take)
{
    return $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);
}

protected function getCategory($alias)
{
    return $this->cat_rep->one($alias, ['title', 'alias', 'keywords', 'meta_desc']);
}*/