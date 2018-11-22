<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CVController extends SiteController
{
    public function __construct()
    {
        parent::__construct();

        $this->title = 'Обо мне';
        $this->template = 'common';
        $this->nav_position = 'right-top';
    }

    public function index(Request $request)
    {
        try {
            $content_view = view('cv_content')
                ->with(['title' => $this->title])
                ->render();
        } catch (\Exception $exception) {
            report($exception);
            $content_view = $this->getError();
        }

        if ($request->isMethod('post')) {
            return response()->json($content_view);
        }

        $this->vars = array_add($this->vars, 'content_view', $content_view);
        return $this->renderOutput();
    }

    public function mail(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'text' => 'required'
        ]);

        $names = [
            'email' => '"E-mail"',
            'text' => '"Сообщение"'
        ];
        $validator->setAttributeNames($names);

        if ($validator->fails()) {
            return view('mail_send_response_content')
                ->withErrors($validator);
        }

        try {
            Mail::to(config('settings.e-mail'), 'Андрей')
                ->send(new Feedback($data));
            return view('mail_send_response_content')
                ->with(['status' => trans('custom.message_sent')]);
        } catch (\Exception $exception) {
            return view('mail_send_response_content')
                ->with(['error' => trans('custom.message_not_sent')]);
        }
    }
}
