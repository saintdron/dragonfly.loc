<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /*if ($exception instanceof CustomException) {

            $content_view = view('runtime-error_content')
                ->with(['message' => $exception->getMessage()])
                ->render();

            if ($request->isMethod('post')) {
                return response()->json($content_view);
            }

            $this->vars = array_add($this->vars, 'content_view', $content_view);

            return $this->renderOutput();

            return response()->view('runtime-error_content', []);
        }*/

//        report($exception);
//dd('ew');
//        return response()->view('errors.500')->render();

        return parent::render($request, $exception);
    }
}
