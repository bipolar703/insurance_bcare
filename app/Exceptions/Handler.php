<?php

namespace App\Exceptions;

use Closure;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            switch (intval($exception->getStatusCode())) {
                // not found
                case 404:
                    if (Auth::guard('super_admin')->check()) {
                        return redirect()->intended(route('super_admin.dashboard'));
                    } elseif (Auth::guard('user')->check()) {
                        return redirect()->intended(route('super_admin.dashboard'));
                    } else {
                        return redirect()->intended(route('welcome'));
                    }
                    break;
            }
        }

        return parent::render($request, $exception);
    }
}
