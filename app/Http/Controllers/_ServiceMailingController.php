<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceMailingController extends Controller
{
    public function sending(Request $request)
    {
        $data = $request->except('_token');

        dd($data);

        /*try {
            Mail::to(config('settings.e-mail'), 'Андрей')
                ->send(new Feedback($data));
            return view('mail_send_response_content')
                ->with(['status' => trans('custom.message_sent')]);
        } catch (\Exception $exception) {
            return view('mail_send_response_content')
                ->with(['error' => trans('custom.message_not_sent')]);
        }*/
    }
}
